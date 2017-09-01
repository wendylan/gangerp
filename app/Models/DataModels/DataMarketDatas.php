<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DataModels\DataMarketDatasChild;

class DataMarketDatas extends Model
{
	use SoftDeletes;
    //
    protected $table = 'data_market_datas';
    protected $dates = ['deleted_at'];
    protected $guarded = [];

	// 获取指定日期内的市场价格
	// @param 标准时间格式
	public function scopeGetMarketDatasFromDate($query, $date){
		$marketData = $query->whereDate('created_at', $date)->get();
		foreach ($marketData as $key => $value) {
            $value->childDatas = (new DataMarketDatasChild())->getChildDataFromParentId($value->id);
        }
		return $marketData;
	}
	public static function getLastDateHasData(){
		return DataMarketDatas::all()->where('display','=',1)->max('created_at')->toDateString();
	}

}
