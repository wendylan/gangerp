<?php
namespace App\Http\Controllers\v1;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\DataModels\DataProject;
use App\Models\DataModels\DataProjectInfo;
use App\Models\DataModels\DataProjectSettlement;

class DataProjectController extends BaseController{

    protected $specification = ['螺纹钢', '盘螺', '高线'];

    # 添加项目
    # 参数 表单Datas 和 项目的结算方式number
    public function add($datas){
        $isAgent = Auth::user()->hasRole('次终端用户');
		try{
			$dataProjectId = [];
			$userId = Auth::id();
            $settlementDatas = $this->countDealPrice($datas);
			DB::transaction(function () use(&$datas, &$dataProjectId, $userId, $settlementDatas, $isAgent) {

				# 插入ProjectInfo表
				$projectInfoId = DataProjectInfo::create([
					'name' => $datas['name'],
					'city' => $datas['city'],
					'area' => $datas['area'],
					'addr' => $datas['addr'],
					'brands' => json_encode($this->brandsToId($datas['brands'], JSON_UNESCAPED_UNICODE)),
                    'receivers' => json_encode($datas['receiverInfo'], JSON_UNESCAPED_UNICODE),
					'settlement' => json_encode($datas['settlement'], JSON_UNESCAPED_UNICODE)
				]);

                # 插入结算方式表
                foreach ($settlementDatas as $key => $value) {
                    $value['project_info_id'] = $projectInfoId['project_info_id'];
                    DataProjectSettlement::create($value);
                }

				# 完成后插入Project表
				$dataProjectId = DataProject::create([
					'user_id' => $isAgent ? -1 : $userId,
                    'supplier_id' => $isAgent ? $userId : -1,
					'project_info_id' => $projectInfoId['project_info_id'],
				]);
			});

			return $dataProjectId;
		}catch(Exception $error){
			$this->response->error('发生了意外的情况, 请重试', 500);
		}
    }

    # 编辑项目
    public function edit($reqDatas){
        $roleId = Auth::user()->hasRole('次终端用户') ? 'supplier_id' : 'user_id';
		$result = DataProject::where($roleId, Auth::id())->where('project_info_id', $reqDatas['project_info_id'])->get()->toArray();

    	if(count($result)){
    		$result = $result[0];
            $projectInfoId = null;
            $settlementDatas = $this->countDealPrice($reqDatas);

            DB::transaction(function () use($reqDatas, &$result, $settlementDatas, &$projectInfoId) {
                # 先删除原有的结算条件
                DataProjectSettlement::where('project_info_id', $reqDatas['project_info_id'])->delete();

        		$projectInfoId = DataProjectInfo::find($result['project_info_id'])->update([
        			'name' => $reqDatas['name'],
        			'city' => $reqDatas['city'],
        			'area' => $reqDatas['area'],
        			'addr' => $reqDatas['addr'],
        			'brands' => json_encode($this->brandsToId($reqDatas['brands'], JSON_UNESCAPED_UNICODE)),
                    'receivers' => json_encode($reqDatas['receiverInfo'], JSON_UNESCAPED_UNICODE),
        			'settlement' => json_encode($reqDatas['settlement'], JSON_UNESCAPED_UNICODE)
        		]);

                # 插入新结算方式表
                foreach ($settlementDatas as $key => $value) {
                    $value['project_info_id'] = $result['project_info_id'];
                    DataProjectSettlement::create($value);
                }
            });
            return $projectInfoId;
    	}else{
    		$this->response->error('没有找到任何项目', 500);
    	}

    }

    # 删除项目
    public function delete($projectId){
        $userProject = DataProject::where('project_id', $projectId)->where('user_id', Auth::id())->take(1)->get();
        return DataProject::destroy($projectId);
    }

    public function getUserProject(){
        $isAgent = Auth::user()->hasRole('次终端用户');
        if($isAgent){
            $projectDatas = DataProject::where('supplier_id', Auth::id())->orWhere('supplier_id', -1)->get()->toArray();
        }else{
            $projectDatas = DataProject::where('user_id', Auth::id())->get()->toArray();
        }

		$result = [];
        # 整理项目数据
		if(count($projectDatas)){
			foreach ($projectDatas as $key => $value) {
				$tempData = DataProjectInfo::where('project_info_id', $value['project_info_id'])->get()->toArray()[0];
                $tempData['receiverInfo'] = json_decode($tempData['receivers']);
                $tempData['settlement'] = json_decode($tempData['settlement']);
				$tempData['brands'] = $this->brandsIdToText(json_decode($tempData['brands']));
                $tempData['project_id'] = $value['project_id'];
                // # 次终端用户能看到属于自己的项目 和 还没有被其他次终端关联的项目
                // if($isAgent && ( $value['user_id']!=-1 || $value['supplier_id']!=-1 ) && ( $value['supplier_id']==Auth::id() || $value['supplier_id']==-1 ) ){
                //     $tempData['company'] = Company::where('user_id', $value['user_id'])->get()->isEmpty() ? null : Company::where('user_id', $value['user_id'])->get()->toArray()[0]['name'];
                // }
                // # 终端用户仅能看到自己的项目
                // if(!$isAgent && $value['user_id']==Auth::id() ){
                //     $tempData['company'] = Company::where('user_id', $value['user_id'])->get()->isEmpty() ? null : Company::where('user_id', $value['user_id'])->get()->toArray()[0]['name'];
                // }
                $tempData['company'] = Company::where('user_id', $value['user_id'])->get()->isEmpty() ? null : Company::where('user_id', $value['user_id'])->get()->toArray()[0]['name'];
                $result[] = $tempData;
			}
			return $result;
		}else{
			return false;
		}
    }

    # 更换项目关联的公司
    # 参数 项目ID 目标用户ID
    # 成功返回true 失败返回-1
    public function changesContact($projectId, $targetId){
        $isAgent = Auth::user()->hasRole('次终端用户');
        $project = DataProject::find($projectId);
        if(isset($project)){
            if($isAgent){
                $project->user_id = $targetId;
                $project->supplier_id = Auth::id();
                return $project->save();
            }else{
                $project->supplier_id = $targetId;
                $project->save();
                return $project->toArray();
            }
        }else{
            return 0;
        }
    }

    # 取消项目关联的公司
    public function cancelContact($projectId){
        $isAgent = Auth::user()->hasRole('次终端用户');
        $project = DataProject::find($projectId);
        if(isset($project)){
            if($isAgent){
                $project->user_id = -1;
                $project->supplier_id = Auth::id();
                return $project->save();
            }else{
                $project->supplier_id = -1;
                $project->save();
                return $project->toArray();
            }
        }else{
            return 0;
        }
    }

    # 将品牌字符串转换成Id
    # 接收一个品牌名称的Array
    public function brandsToId($brandsArr){
    	$brandsList = DB::table('steel_factorys')->get()->toArray();
    	foreach ($brandsList as $key => $value) {
    		foreach ($brandsArr as $index => $val) {
    			if($val == $value->abbreviation){
    				$brandsArr[$index] = $value->id;
    			}
    		}
    	}
    	return $brandsArr;
    }

	# 将品牌Id字符串转换成品牌字符串
    # 接收一个品牌id的Array
	public function brandsIdToText($idArr){
		$brandsList = DB::table('steel_factorys')->get()->toArray();
		$resultArr = [];
    	foreach ($brandsList as $key => $value) {
    		foreach ($idArr as $index => $val) {
    			if($val == $value->id){
    				$resultArr[] = $value->abbreviation;
    			}
    		}
    	}
    	return $resultArr;
	}

	# 根据结算方式, 以不同的方法计算合同价
	public function countDealPrice($datas){
		if($datas['settlement']['conditionType'] == 1){
			$resultDatas = [];
			foreach ($datas['brands'] as $key => $value) {
				foreach ($this->specification as $index => $val) {
					$resultDatas[] = [
                        'type' => 1,
						'brand' => $value,
						'specification' => $val,
						'reference' => $datas['settlement']['priceType'],
						'count_number' => $datas['settlement']['calculateType']=='上浮' ? $datas['settlement']['price'] : -$datas['settlement']['price']
					];
				}

			}
			return $resultDatas;
		}else if($datas['settlement']['conditionType'] == 2){
            foreach ($datas['settlement']['childData'] as $key => $value) {
                foreach ($this->specification as $index => $val) {
                    # code...
                    $resultDatas[] = [
                        'type' => 2,
                        'brand' => $value['onemoreBrand'],
                        'specification' => $val,
                        'reference' => $value['priceType'],
                        'count_number' => $value['calculateType']=='上浮' ? $value['price'] : -$value['price']
                    ];
                }
            }
            return $resultDatas;
		}else if($datas['settlement']['conditionType'] == 3){
            foreach ($datas['brands'] as $key => $value) {
                foreach ($datas['settlement']['cate_spec'] as $index => $val) {
                    $resultDatas[] = [
                        'type' => 3,
                        'brand' => $value,
                        'specification' => $val['name'],
                        'reference' => '网价',
                        'count_number' => $val['calculateType']=='上浮' ? $val['price'] : -$val['price']
                    ];
                }
            }
            return $resultDatas;
        }else if($datas['settlement']['conditionType'] == 4){
            foreach ($datas['brands'] as $key => $value) {
                # code...
                foreach ($this->specification as $index => $val) {
                    # code...
                    $resultDatas[] = [
                        'type' => 4,
                        'brand' => $value,
                        'specification' => $val,
                        'reference' => $datas['settlement']['priceType'],
                        'count_number' => $datas['settlement']['calculateType']=='上浮' ? $datas['settlement']['price'] : -$datas['settlement']['price'],
                        'freight' => $datas['settlement']['freight'],
                        'ponderation' => $datas['settlement']['ponderation_price']
                    ];
                }
            }
            return $resultDatas;
        }else if($datas['settlement']['conditionType'] == 5){
            foreach ($datas['settlement']['childData'] as $key => $value) {
                foreach ($this->specification as $index => $val) {
                    # code...
                    $resultDatas[] = [
                        'type' => 5,
                        'brand' => $value['onemoreBrand'],
                        'specification' => $val,
                        'reference' => $value['priceType'],
                        'count_number' => $value['calculateType']=='上浮' ? $value['price'] : -$value['price'],
                        'freight' => $datas['settlement']['freight'],
                        'ponderation' => $datas['settlement']['ponderation_price']
                    ];
                }
            }
            return $resultDatas;
        }else if($datas['settlement']['conditionType'] == 6){
            foreach ($datas['brands'] as $key => $value) {
                # code...
                foreach ($this->specification as $index => $val) {
                    # code...
                    $resultDatas[] = [
                        'type' => 6,
                        'brand' => $value,
                        'specification' => $val,
                        'reference' => $datas['settlement']['priceType'],
                        'count_number' => $datas['settlement']['calculateType']=='上浮' ? $datas['settlement']['price'] : -$datas['settlement']['price'],
                        'freight' => $datas['settlement']['freight'],
                        'ponderation' => $datas['settlement']['ponderation_price'],
                        'crane' => $datas['settlement']['crane_price'],
                        'funds_rate' => $datas['settlement']['funds_price_rate']
                    ];
                }
            }
            return $resultDatas;
        }else if($datas['settlement']['conditionType'] == 7){
            foreach ($datas['settlement']['childData'] as $key => $value) {
                foreach ($this->specification as $index => $val) {
                    # code...
                    $resultDatas[] = [
                        'type' => 7,
                        'brand' => $value['onemoreBrand'],
                        'specification' => $val
                    ];
                }
            }
            return $resultDatas;
        }
	}

}
