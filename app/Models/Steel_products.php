<?php

namespace App\Models;
use DB;
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
	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	// public function factorys()
    // {
    //     return $this->belongsTo('App\Models\Steel_factory', 'brand_id');
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
