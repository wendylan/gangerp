<?php

namespace App\Models\DataModels;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\DataModels\DataWebPriceDate;
use App\Models\DataModels\DataWebPrice;

class DataWebPriceDate extends Model
{
    //
    protected $table = 'data_web_price_date';
    protected $guarded = [];

    // 获取指定日期内的所有报价
    // @parmas 标准时间格式$date  是否仅获取子表内容$isWantChildData
    public function getWebPriceByDate($date, $isWantChildData=false){
        $timeHandle = Carbon::parse($date);
        $webPriceDatas = DataWebPriceDate::where('date', '<', ($timeHandle->timestamp+86400) )->where('date', '>', $timeHandle->timestamp)->get();

        if(!$isWantChildData){
            return $webPriceDatas;
        }else{
            foreach ($webPriceDatas as $key => $value) {
                $value['childDatas'] = DataWebPrice::where('file_name', $value->date)->get()->toArray();
            }
            return $webPriceDatas;
        }
    }

    // 获取最后一次网价
    static function getWebPriceNewly(){
        $webPrice =  DataWebPriceDate::orderBy('id', 'DESC')->first();
        return $webPrice;
    }

    //关联关系
    public function getPrice(){
        return $this->hasMany('App\Models\DataModels\DataWebPrice', 'file_name', 'date');
    }

}
