<?php

namespace App\Models\DataModels;

use App\Http\Controllers\v1\BaseController;
use Illuminate\Database\Eloquent\Model;
use DB;
class DataUserOrdersDetail extends Model
{
	protected $table = 'data_user_orders_detail';
    public $marketData;
    public function __construct( ){
        $this->marketData = $this->hasOneMarketData()->get() ;
    }
    public static function formatOrderDetail($data){
        $orderDetails = [];
        foreach ($data as $key => $value) {
            if (!array_key_exists('plate_num',$value)) {
               $value['plate_num'] = '';     
            }
            if(intval($value['amount'])<=0){
                $response = new BaseController();
                $response->response->error('数量不能为空或小于0',500);
            }
            $orderDetails[]=array(
                'unit_price' => $value['unit_price'],
                'amount' => $value['amount'],
                'total' => $value['amount']*$value['unit_price'],
                'brand' => $value['brand'],
                'cate_spec' => $value['cate_spec'],
                'material' => $value['material'],
                'size' => $value['size'],
                'plate_num' => $value['plate_num']
            );
        }
        return $orderDetails ;
    }
    public static function formatStOrderDetail($data){
        $orderDetails = [];
        foreach ($data as $key => $value) {
            if (!array_key_exists('plate_num',$value)) {
               $value['plate_num'] = '';     
            }
            if(intval($value['amount'])<=0){
                $response = new BaseController();
                $response->response->error('数量不能为空或小于0',500);
            }
            $orderDetails[]=array(
                'unit_price' => $value['unit_price'],
                'amount' => $value['amount'],
                'total' => $value['amount']*$value['unit_price'],
                'brand' => $value['brand'],
                'cate_spec' => $value['cate_spec'],
                'material' => $value['material'],
                'size' => $value['size'],
                'plate_num' => $value['plate_num'],
                'warehouse' => $value['warehouse'],
                'freight' => $value['freight']
            );
        }
        return $orderDetails ;
    }

 
    
	public function belongsToDataUserOrders(){
    	return $this->belongsTo('App\Models\DataModels\DataUserOrders','order_id','id');
    }
    public function hasOneMarketData(){
        return $this->hasOne('App\Models\DataModels\DataMarketDatasChild', 'id', 'market_price_id');
    }
    
}