<?php

namespace App\Models;
use DB;
use Log;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Steel_products extends Model
{
	use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

	protected $table = 'steel_products';
	protected $primaryKey = 'id';
	// public $timestamps = false;
	// protected $guarded = ['id'];
	 protected $fillable = ['bid','steel_code','spec','spec_key'];
	// protected $hidden = [];
    // protected $dates = [];
	public $timestamps = true;

	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

	// 返回指定品牌的钢铁规格
	// @param $brandName 品牌名称
	public function scopeGetBrandSteelSpecs($query, $brandName){
		$result=array();
		$_result=array();
		$specs = $query->where('brand', $brandName)->get();
		// 品名和材质去重
		foreach ($specs as $key => $value) {
			$result[$value->cate_spec][$value->material][]=$value->size;
		}
		// 组合成树形结构数据
		$count = 0;
		foreach ($result as $name => $value) {
			$_result[] = array('name'=>$name);
			foreach ($result[$name] as $material => $_value) {
				$_result[$count]['material'][] = array('name'=>$material);
				$arrLength = count($_result[$count]['material']) - 1;
				// Size去重
				$result[$name][$material] = array_unique($result[$name][$material]);

				foreach ($result[$name][$material] as $index => $size) {
					if($_result[$count]['material'][$arrLength]['name'] == $material){
						$_result[$count]['material'][$arrLength]['size'][] = array('name'=>$size);
					}
				}
			}
			$count += 1;
		}
		return $_result;
	}

	//  获取所有品牌名称
	public function scopeGetAllBrandsName($query){
		$result = [];
		$brandsName = $query->select('brand')->get();
		foreach ($brandsName->toArray() as $key => $value) {
			$result[] = $value['brand'];
		}
		return array_values(array_unique($result));
	}
	public static function getAllProductInfo(){
		$product = DB::table('steel_products');
		$brand = $product->select('brand')->distinct()->get();
		$cate_spec = $product->select('cate_spec')->get();
		$size = $product->select('size')->get();
		$material = $product->select('material')->get();
		return array('brand' =>$brand ,'cate_spec' =>$cate_spec ,'size' =>$size ,'material' =>$material );
	}
	public static function getBrandGroupSpec($brands){
		$_this = new steel_products();
		$brandSpecGruop = [];
		$pickup = collect();
		foreach ($brands as $key => $value) {
			$product = DB::table('steel_products');
			$brandSpec = $product->where('brand',$value)->select('cate_spec','size','material')->get();
			$pickup = $pickup->merge($brandSpec->toArray());
		}
		$pickup = $pickup->unique();
		$result = $_this->toTree($pickup,$_this);
		return $result;
	}

	public function toTree($data,$_this){
		$tree=[];
		foreach ($data as $value) {
			if($_this->isNameExist($value->cate_spec,$tree)){
				$cate_spec_key = $_this->getDataKey($value->cate_spec,$tree);
				$cate_spec = $tree[$cate_spec_key];
				if ($_this->isNameExist($value->material,$cate_spec['material'])) {
					$material_key = $_this->getDataKey($value->material,$cate_spec['material']);
					$material = $cate_spec['material'][$material_key];
					if($_this->isNameExist($value->size,$material['size'])){
						continue;
					}else{
						array_push($tree[$cate_spec_key]['material'][$material_key]['size'],array('name'=>$value->size));
					}
				}else{
					array_push($tree[$cate_spec_key]['material'],array('name'=>$value->material,'size'=>array(['name'=>$value->size])));
				}
			}else{
				array_push($tree,array('name'=>$value->cate_spec,'material'=>array(['name'=>$value->material,'size'=>array(['name'=>$value->size])])));
			}
		}
		return $tree;
	}



	public function isNameExist($name,$data){
		// Log::info($data);
		foreach ($data as $value) {
			if ($value['name']==$name) {
				return true;
			}
		}
		return false;
	}

	public function  getDataKey($name,$data){
		foreach ($data as $key=>$value) {
			if ($value['name']==$name) {
				return $key;
			}
		}
		return null;
	}
	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	// public function factorys()
    // {
    //     return $_this->belongsTo('App\Models\Steel_factory', 'brand_id');
    // }

	/*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
