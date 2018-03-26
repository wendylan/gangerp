<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DataModels\DataMarketDatasChild;
use Carbon\Carbon;
use DB;

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

	// 获取最后发布的一次市场价
	public static function getDataNewly(){
		$lastDate = DataMarketDatas::all()
									->where('display','=',1)
									->max('created_at')
									->toDateString();
		$marketPrice = DataMarketDatas::where('display', '=', 1)->whereDate('created_at', $lastDate)->first();
		return $marketPrice;
	}

	// 获取最后一次报价的发布日期
	public static function getLastDateHasData(){
		return DataMarketDatas::all()->where('display','=',1)->max('created_at')->toDateString();
	}

	public static function GetMarketDatasChildWithPriceSourceSShortName($query, $date){
		$marketData = $query->whereDate('created_at', $date)->get();
		foreach ($marketData as $key => $value) {
            $value->childDatas = (new DataMarketDatasChild())->getChildDataFromParentId($value->id);
        }
		return $marketData;
	}

	public static function getParentIdByDate($date){
		return DataMarketDatas::where('created_at','like',$date."%")->where('display','=',1)->get();
	}

	// 创建当天最新报价
	static function createMarketReport(){
		$firstTime = Carbon::createFromTime(9, 00, 0);
		$secondTime = Carbon::createFromTime(9, 30, 0);
		$nowTime = Carbon::now();
		$newlyDatas = [];

		// 如果当天已有两次报价, 结束程序
		$times = count(DataMarketDatas::whereDate('created_at', Carbon::today())->get());
		if($times >= 2){
			return false;
		}

		// 当前时间是否超过12:00
		// 获取指定时段的最新数据
		if($nowTime->gt($firstTime) && $nowTime->lt($secondTime)){
			$newlyDatas = self::countNewMarketDatas(1, $firstTime);
		}else if($nowTime->gt($secondTime)){
			$newlyDatas = self::countNewMarketDatas(2, $firstTime);
		}

	    // 关联最新报价的父表
	    DB::transaction(function () use($newlyDatas) {
			$todayReport = DataMarketDatas::whereDate('created_at', Carbon::today())->get()->toArray();
			$todayReportTimes = count($todayReport);
			$parent_id = DataMarketDatas::insertGetId([ 'price_queue'=>$todayReportTimes, 'display' => 1, 'created_at'=>Carbon::now() ]);
			foreach ($newlyDatas as $key => $value) {
				$id = $value['id'];
				if($value['price'] != 0){
					DataMarketDatasChild::where('id', $id)->update([ 'parent_id' => $parent_id ]);
				}
			}
		});

        return [ 'newlyDatas'=>$newlyDatas ];
	}

	// 参数 : type(是第一还是第二次报价) fristTime(规定的第一次发布时间)
	static function countNewMarketDatas($type, $fristTime){
		$newlyDatas = [];
		$firstDatas = [];
	    $arr = [];
		// 判断一二次报价
		if($type == 1){
			// 获取指定报价时间前的价格$firstDatas
			$firstDatas = DataMarketDatasChild::whereDate('created_at', '=', Carbon::today())
				->whereTime('created_at', '<', $fristTime->toTimeString())
				->get()->toArray();
		}else{
			$firstDatas = DataMarketDatasChild::whereDate('created_at', '=', Carbon::today())
				->whereTime('created_at', '>', $fristTime->toTimeString())
				->get()->toArray();
		}

		// 整合$firstDatas 计算目前最新价格
		$newlyDatas = DataMarketDatasChild::makeNewlyDatas($firstDatas);
	    foreach ($newlyDatas as $key => $value) {
	        if(count($value)>0){
	            $arr[] = $value[count($value)-1];
	        }else{
	            $arr[] = $value[0];
	        }
	    }
	    $newlyDatas = $arr;
		return $newlyDatas;
	}

	// 关联关系
	public function getPrice(){
		return $this->hasMany('App\Models\DataModels\DataMarketDatasChild', 'parent_id', 'id');
	}

}
