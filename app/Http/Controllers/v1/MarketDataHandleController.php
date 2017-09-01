<?php
namespace App\Http\Controllers\v1;
use Illuminate\Http\Request;
use DB;

class MarketDataHandleController extends BaseController
{
	//定价规则
	public function marketDataHandle($data){
		//获取当前使用的定价规则
		$rule=DB::table('data_market_rule')->where('apply_states',1)->get();
		//返回值
		$dataReturn=[];
		foreach ($data as $key => $value) {
			foreach ($rule as $rulekey => $rulevalue) {
				if ($rulevalue->trandsport=="自提") {
					$rulevalue->trandsport="广州仓发货";
				}
				if ($key==0) {
					$rulevalue->apply_brands=explode(",",$rulevalue->apply_brands);
				}
				//提货方式选择所有
				if ($rulevalue->trandsport=="自提、直送") {
					//品牌选中所有
					if ($rulevalue->apply_brands[0]=="所有品牌") {

						if ($key==0) {
							$value->price=[$value->price];
							$value->count=1;
							$dataReturn[]=$value;
						}else{
							if($this->dataJudge($dataReturn,$value->brand,$value->cate_spec,$value->material,$value->size,$value->transport,$value->parent_id,$value->price)){

							}else{
								$value->price=[$value->price];
								$value->count=1;
								$dataReturn[]=$value;
							}
						}
					//个别品牌选中
					}else{
						foreach ($rulevalue->apply_brands as $appkey => $appvalue) {
							if ($appvalue==$value->brand) {
								if ($key==0) {
									$value->price=[$value->price];
									$value->count=1;
									$dataReturn[]=$value;
								}else{
									if($this->dataJudge($dataReturn,$value->brand,$value->cate_spec,$value->material
										,$value->size,$value->transport,$value->parent_id,$value->price)){

									}else{
										$value->price=[$value->price];
										$value->count=1;
										$dataReturn[]=$value;
									}
								}
							}
						}
					}
				//个别提货方式选中
				}else if($value->transport==$rulevalue->trandsport){
					//品牌选中所有
					if ($rulevalue->apply_brands[0]=="所有品牌") {
						if ($key==0) {
							$value->price=[$value->price];
							$value->count=1;
							$dataReturn[]=$value;
						}else{
							if($this->dataJudge($dataReturn,$value->brand,$value->cate_spec,$value->material,$value->size,$value->transport,$value->parent_id,$value->price)){

							}else{
								$value->price=[$value->price];
								$value->count=1;
								$dataReturn[]=$value;
							}
						}
					//个别品牌选中
					}else{
						foreach ($rulevalue->apply_brands as $appkey => $appvalue) {
							if ($appvalue==$value->brand) {
								if ($key==0) {
									$value->price=[$value->price];
									$value->count=1;
									$dataReturn[]=$value;
								}else{
									if($this->dataJudge($dataReturn,$value->brand,$value->cate_spec,$value->material,$value->size,$value->transport,$value->parent_id,$value->price)){

									}else{
										$value->price=[$value->price];
										$value->count=1;
										$dataReturn[]=$value;
									}
								}
							}
						}
					}
				}
			}
		}
		//价格计算
		foreach ($dataReturn as $key => $value) {
			//样本大于等于3
			if ($value->count>2) {
				krsort($value->price);
				array_shift($value->price);
				array_pop($value->price);
				$value->price=intval(array_sum($value->price)/sizeof($value->price));
			//样本等于2（1时不用做任何操作）
			}else {
				$value->price=intval(array_sum($value->price)/sizeof($value->price));
			}
			$value->price_source="广东广物供应链管理有限公司";
		}
		// dd($dataReturn);
		return $dataReturn;
	}
	//样本分类
	function dataJudge(Array $dataReturn,$brand,$cate_spec,$material,$size,$transport,$parent_id,$price){
		foreach ($dataReturn as  $datavalue) {
			if ($datavalue->brand==$brand&&$datavalue->cate_spec==$cate_spec&&$datavalue->transport==$transport
				&&$datavalue->material==$material&&$datavalue->size==$size&&$datavalue->parent_id==$parent_id) {
				$datavalue->price[]=$price;
				$datavalue->count+=1;
				return 1;
			}
		}
		return 0;
	}
	//获取定价规则
	public function getRule(){
		$rule=DB::table('data_market_rule')->get();
		return $this->responseBuild( $rule );
	}

	//更新定价规则品牌信息到数据库
	public function getRuleData(Request $req){
		$trandsport=$req->trandsport;
		$apply_brands_req=$req->apply_brands;
		$apply_brands="";
		foreach ($apply_brands_req as $key => $value) {
			if($key==0){
				$apply_brands=$apply_brands.$value;
			}else{
				$apply_brands=$apply_brands.",".$value;
			}
		}
		DB::table('data_market_rule')
            ->where('apply_states', 1)
            ->update(['apply_states'=>0]);

		DB::table('data_market_rule')
            ->where('id', $req->id)
            ->update(['apply_brands' =>$apply_brands,'trandsport'=>$trandsport,'apply_states'=>$req->apply_states]);

		return $this->responseBuild( null );
	}


}
