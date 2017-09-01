<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use App\Models\DataModels\DataWebPrice;

class DataWebPrice extends Model
{
    //
    protected $table = 'data_web_price';
    protected $guarded = [];

    // @parma Y:M:D 日期格式
	public function getWebPriceFromDate($date){
		// 获取数据创建当天的网价
        $createdDate = substr($date, 0, 10);
        $searchdTime = strtotime($createdDate);
        $endTime = strtotime($createdDate) + 86400;
		return DataWebPrice::whereBetween('file_name', [$searchdTime, $endTime])->get();
	}

}
