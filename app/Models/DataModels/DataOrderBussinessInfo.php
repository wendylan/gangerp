<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;

class DataOrderBussinessInfo extends Model
{
    //
    protected $table = 'data_order_bussiness_info';
    protected $guarded = [];

	// 获取指定日期内的市场价格
	// @param 标准时间格式
	public function getOrderBussinessInfo($order_id){
		return $this::where('order_id',$order_id)->get();
	}       
}
