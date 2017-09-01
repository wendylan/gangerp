<?php

namespace App\Models\DataModels;

use App\Http\Controllers\v1\BaseController;
use Illuminate\Database\Eloquent\Model;
use DB;
class DataUserOrdersDetail extends Model
{
	protected $table = 'data_user_orders_detail';

	public function belongsToDataUserOrders(){
    	return $this->belongsTo('App\Models\DataModels\DataUserOrders','order_id','id');
    }
    
    
    public static function formatOrderDetail($data){
        $orderDetails = [];
        // dd($data);
        foreach ($data as $key => $value) {
            if (!array_key_exists('plate_num',$value)) {
               $value['plate_num'] = '';     
            }
            if(intval($value['amount'])<=0){
                $response = new BaseController();
                $response->response->error('数量不能为空或小于0',500);
            }
            $orderDetails[]=array(
                'market_price_id' => $value['id'],
                'unit_price' => $value['price'],
                'amount' => $value['amount'],
                'total' => $value['amount']*$value['price'],
                'brand' => $value['brand'],
                'cate_spec' => $value['cate_spec'],
                'material' => $value['material'],
                'freight' => $value['freight'],
                'size' => $value['size'],
                'price' => $value['price'],
                'warehouse' => $value['warehouse'],
                'plate_num' => $value['plate_num']
            );
        }
        return $orderDetails ;
    }
    
}