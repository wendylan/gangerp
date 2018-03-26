<?php
namespace App\Http\Controllers\v1;
use Illuminate\Http\Request;
use DB;
use App\Models\DataModels\DataMarketPriceRule;
use App\Models\Steel_products;
use App\Models\DataModels\DataMarketRule;
use App\Models\DataModels\DataPriceSource;

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

	// 保存定价规则
	public function edit(Request $request){
		$active_rule = $request->active_rule;
		$content = $request->content;
		$brand_id = $request->brand_id;
		$result = DB::transaction(function () use($content, $active_rule, $brand_id) {
			DataMarketRule::where('brand_id', $brand_id)->update(['active_rule' => $active_rule]);
			foreach ($content as $key => $value) {
				$id = $value['id'];
				unset($value['id']);
				if($active_rule == 1){
					DataMarketPriceRule::where('id', $id)
					->update([ 'float_type'=>$value['float_type'], 'float_price'=>$value['float_price'], 'supplier_id'=>$value['supplier_id']]);
				}else{
					DataMarketPriceRule::where('id', $id)
					->update([ 'customize_float_type'=>$value['customize_float_type'], 'customize_float_price'=>$value['customize_float_price'], 'supplier_id'=>$value['supplier_id']]);
				}
				
			}
		});

		return $this->responseBuild($result);
	}

	// 保存开单操作
	public function changeState(Request $request){
		$range = $request->range ? $request->range : null;
		$action = $request->action ? $request->action : null;
		$content = $request->content;
		$result;

		if($range == null){
			$result = DB::transaction(function () use($content) {
				foreach ($content as $key => $value) {
					DataMarketPriceRule::where('id', $value['id'])
						->update(['is_active' => $value['is_active']]);
				}
			});
		}else if($range == 'all'){
			$allSteel = Steel_products::all()->toArray();
			$result = DB::transaction(function () use($allSteel, $action) {
				foreach ($allSteel as $key => $value) {
					DataMarketPriceRule::where('steel_products_id', $value['id'])
						->update(['is_active' => ($action=='close' ? 0 : 1)]);
				}
			});
		}


		return $this->responseBuild($result);
	}

	// 处理基础数据 根据rule来计算买买买价格
	// 符合rule的市场价或新增三个属性 
	// hasRuleChanged(是否有改变) is_active(是否开单状态) base_price(改变前的价格)
	public function handleMarketDatas(Array $marketDatas){
		// 获取规则数据
		$rules = DB::table('data_market_price_rule')
			->join('steel_products', 'data_market_price_rule.steel_products_id', '=', 'steel_products.id')
			->leftJoin('data_price_source', 'data_market_price_rule.supplier_id', '=', 'data_price_source.id')
			->select('brand', 'cate_spec', 'material', 'size', 'name', 'is_active', 'float_type', 'float_price')
			->get()->toArray();

		// 根据规则计算现货价
		foreach ($rules as $key => $value) {
			foreach ($marketDatas as $index => $val) {
				if( 
					$value->brand == $val['brand'] &&
					$value->cate_spec == $val['cate_spec'] &&
					$value->material == $val['material'] &&
					$value->size == $val['size'] &&
					($value->float_type == 1 ? true : $value->name == $val['price_source'])
				){
					$marketDatas[$index]['hasRuleChanged'] = true;
					$marketDatas[$index]['is_active'] = $value->is_active;
					$marketDatas[$index]['base_price'] = $val['price'];
					$marketDatas[$index]['price'] = (int)$val['price'] + $value->float_price;
					break;
				}
			}
		}
		return $marketDatas;
	}

	// 获取指定品牌的定价规则
    public function getMarketPriceStateByBrand(Request $request){
        $result = [];
        $brand = $request->brand;
        $brands = DataMarketRule::fullDatas();

        // databaes中是否有匹配的品牌
        $active_rule = false;
        foreach ($brands as $key => $value) {
            if($value['abbreviation'] == $brand){
                $active_rule = $value['active_rule'];
            }
        }

        if($active_rule){
            $modelDatas = DataMarketPriceRule::all();
            $tempSupplier = DataPriceSource::all()->toArray();
            $result['active_rule'] = $active_rule;
            foreach ($modelDatas as $key => $value) {
                $suppler = $value->suppler;
                $steel = $value->steel;
                if($steel!=null && $brand == $steel->brand){
                    $result['content'][] = [ 'id'=>$value->id, 'cate_spec'=>$steel->cate_spec, 'material'=>$steel->material, 'size'=>$steel->size, 'floatType'=>$value->float_type, 'floatPrice'=>$value->float_price, 'customizeFloatType'=>$value->customize_float_type, 'customizeFloatPrice'=>$value->customize_float_price, 'isActive'=>$value->is_active, 'supplier_selected'=>$value->supplier_id?$value->supplier_id:null, 'suppliers'=> $tempSupplier ];
                }
            }
            return $this->responseBuild($result);
        }else{
            return $this->response->error('参数有误', 500);
        }

    }

}
