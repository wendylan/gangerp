<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DataModels\DataUserOrdersDetail;
use App\Models\DataModels\DataOrderLogisticsInfo;
use App\Models\DataModels\DataUser as User;
use App\Models\DataModels\DataProjectInfo as Project;
use App\Http\Controllers\v1\BaseController;


class DataUserOrders extends Model
{
    use SoftDeletes;
    
    protected $table = 'data_user_orders';
    protected $dates = ['deleted_at'];
    protected $guarded = [];
    
    public function getUserOrder( $id ){
        $userOrders = $this::where('user_id','=',$id)->get()->sortByDesc('id');
        foreach ($userOrders as $key => $value) {
            $value->orderDetail = $value->hasManyOrderDetail()->get();
            $value->logisticsInfo =  $value->hasManyLogisticsInfo()->get();
        }
        $data = [];
        foreach ($userOrders as $key => $value) {
            $data []= $value;
        }
        return collect($data);
    }
    public function getAllOrder(){
        $allOrder = $this::all()->where('status','<>',-1);
        foreach ($allOrder as $key => $value) {
            $value->orderDetail = $value->hasManyOrderDetail()->get();
            $value->user_name=User::find($value->user_id)->name;
            $value->project = Project::find($value->project_id);
            $value->logisticsInfo =  $value->hasManyLogisticsInfo()->get();
        }
        return $allOrder;
    }
    public function finishOrder($data){
        $order = $this::find($data['id']);
        $order->status = 3;
        $order->save();
        $order->orderDetail = $order->hasManyOrderDetail()->get();
        $order->logisticsInfo = $order->hasManyLogisticsInfo()->get();
        $order->project = Project::find($order->project_id);
        return $order;
    }
    public function resendOrder($data){
        $order = $this::find($data['id']);
        $order->status = 0;
        $order->transport_function = $data['transport_function'];
        $order->all_total = $this->getAllTotal($data['detailOrder']);
        $order->count_total = $this->getCountTotal($data['detailOrder']);
        $order->receiver = $data['receiver'];
        $order->receiver_tel = $data['receiver_tel'];
        $order->date_of_receipt = $data['date_of_receipt'];
        $order->place_of_receipt = $data['place_of_receipt'];
        $order->remarks = $data['remarks'];
        $order->save();
        $this->updateOrderDetail($data['detailOrder'],$data['id'],$data['status']);
        $order->orderDetail = $order->hasManyOrderDetail()->get();
        $order->project = Project::find($order->project_id);
        if(array_key_exists('logistics_info',$data)){
            $order->logisticsInfo = $this->updateLogistics($data['logistics_info'],$data['id']);
        }
        $order->user_name=User::find($order->user_id)->name;
        return $order;
    }
    public function cancelOrder($data){
        $order = $this::find($data['id']);
        $order->status = intval($data['status'])*-1;
        $order->save();
        $order->orderDetail = $order->hasManyOrderDetail()->get();
        $order->logisticsInfo = $order->hasManyLogisticsInfo()->get();
        $order->user_name=User::find($order->user_id)->name;
        return $order;
    }
    public function deleteOrder($data){
        $order = $this::find($data['id']);
        $order = $order->delete();
        return $order;
    }
    public function updateOrder($data){
        $order = $this::find($data['id']);
        $order->status = 2;
        $order->transport_function = $data['transport_function'];
        $order->all_total = $this->getAllTotal($data['detailOrder']);
        $order->count_total = $this->getCountTotal($data['detailOrder']);
        $order->receiver = $data['receiver'];
        $order->receiver_tel = $data['receiver_tel'];
        $order->date_of_receipt = $data['date_of_receipt'];
        $order->place_of_receipt = $data['place_of_receipt'];
        $order->remarks = $data['remarks'];
        $order->save();
        $this->updateOrderDetail($data['detailOrder'],$data['id'],$data['status']);
        $order->orderDetail = $order->hasManyOrderDetail()->get();
        $order->project = Project::find($order->project_id);
        if(array_key_exists('logistics_info',$data)){
            $order->logisticsInfo = $this->updateLogistics($data['logistics_info'],$data['id']);
        }
        $order->user_name=User::find($order->user_id)->name;
        return $order;
    }
    public function updateOrderDetail($data, $order_id, $status){
        $orderDetails=[];
        foreach ($data as $key => $value) {

            if($value['id']){
                $orderDetail = DataUserOrdersDetail::find($value['id']);
                $orderDetail->market_price_id = $value['market_price_id'];
                $orderDetail->web_price_id = $value['web_price_id'];
                $orderDetail->brand = $value['brand'];
                $orderDetail->cate_spec = $value['cate_spec'];
                $orderDetail->size = $value['size'];
                $orderDetail->material = $value['material'];
                $orderDetail->warehouse = $value['warehouse'];
                $orderDetail->freight = $value['freight'];
                $orderDetail->price = $value['price'];
                $orderDetail->unit_price = $value['unit_price'];
                $orderDetail->amount = $value['amount'];
                $orderDetail->total = $value['total'];
                $orderDetail->remark = $value['remark'];
                $orderDetail->plate_num = $value['plate_num'];
                $orderDetail->save();
                // $orderDetails [] = $orderDetail;
            }else{
                unset($value['id']);
                unset($value['menu']);
                $insertData []= $value;
                $orderDetail = DataUserOrdersDetail::insert($insertData);
            }

            if(intval($value['amount']) < 0){
                $order = $this::find($order_id);
                $order->status = $status;
                $order->save();
                $response = new BaseController();
                $response->response->error('计划吨数不能为空或小于0',500);
            }

        }
        return $orderDetails;
    }
    public function updateLogistics($data,$order_id){
        foreach ($data as $key => $value) {
            $id_card_model = "/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/";
            $driver_tel_model = "/^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/";
            if(!preg_match($id_card_model,$value['driver_idcard_num'])){
                $response = new BaseController();
                $response->response->error('司机身份证不符合规则',500);
            }
            if(!preg_match($driver_tel_model,$value['driver_tel'])){
                $response = new BaseController();
                $response->response->error('司机电话号码不符合规则',500);
            }
            if (array_key_exists('id',$value)) {
                $logisticsInfo = DataOrderLogisticsInfo::find($value['id']);
                $logisticsInfo->plate_number = $value['plate_number'];
                $logisticsInfo->driver = $value['driver'];
                $logisticsInfo->driver_tel = $value['driver_tel'];
                $logisticsInfo->driver_idcard_num = $value['driver_idcard_num'];
                $logisticsInfo->save() ;
            }else{
                $judge = count(array_unique($value))==1&&$value['driver'];
                if($judge){
                    continue;
                }
                $value['order_id'] = $order_id;
                $logisticsInfo=DataOrderLogisticsInfo::insert($value);
            }
        }
        $logisticsInfos = DataOrderLogisticsInfo::where('order_id',$order_id)->get();
        return $logisticsInfos;
    }

    public  function saveOrder($data){
        $count = $this::where('project_id',$data['project_id'])->where('created_at','like',date('Y-m-d').'%')->count();
        $project = Project::find($data['project_id'])->name;
        $data['order_number'] = $data['order_number'].'-'.$count.$project;
        $orderDetail = DataUserOrdersDetail::formatOrderDetail($data['detailOrder']);
        $logistics_info = $data['logistics_info'] ;
        if($data['transport_function']){
            foreach ($logistics_info as $key => $value) {
                $id_card_model = "/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/";
                $driver_tel_model = "/^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/";
                if(!preg_match($id_card_model,$value['driver_idcard_num'])){
                    $response = new BaseController();
                    $response->response->error('司机身份证不符合规则',500);
                }
                if(!preg_match($driver_tel_model,$value['driver_tel'])){
                    $response = new BaseController();
                    $response->response->error('司机电话号码不符合规则',500);
                }
            }
        }
        unset($data['logistics_info']);
        unset($data['detailOrder']);
        $result = $this::create($data);
        $result->detail = $result->saveOrderDetail($orderDetail);
        if($data['transport_function']){
            $result->logistics_info = $result->saveLogisticsInfo($logistics_info);
        }
        return $result;
    }
    public function saveOrderDetail($data){
        $orderDetail = [];
        foreach ($data as $key => $value) {
            $value['order_id'] = $this->id;
            $orderDetail[] = $value;
        }
        return DataUserOrdersDetail::insert($orderDetail);
    }
    public function saveLogisticsInfo($data){
        $logistics_info = [];
        foreach ($data as $key => $value) {
            $value['order_id'] = $this->id;
            $logistics_info[] = $value;
        }
        return DataOrderLogisticsInfo::insert($logistics_info);
    }
    public function getAllTotal($orderDetail){
        $all_total = 0;
        foreach ($orderDetail as $key => $value) {
            $num = $this->getNum($value);
            $all_total+=$num*$value['price'];
        }
        return $all_total;
    }
    public function getCountTotal($orderDetail){
        $count_total = 0;
        foreach ($orderDetail as $key => $value) {
            $num = $this->getNum($value);
            $count_total+=$num;
        }
        return $count_total;
    }
    public function getNum($data){
        if(array_key_exists('amount',$data)){
            return $data['amount'];
        }
        else{
            return $data['num'];
        }
    }
    //订单条目关联（网价或现货假）
    public function relationWhitWebPrice($data){
        return $data->join('data_web_price','web_price_id','=','data_web_price.id');
    }
    public function relationWhitMarketPrice($data){
        return $data->join('data_market_datas_child','market_price_id','=','data_market_datas_child.id');
    }
    //hasmany and belong to
    public function hasManyOrderDetail(){
        return $this->hasMany('App\Models\DataModels\DataUserOrdersDetail','order_id','id');
    }

    public function hasManyLogisticsInfo(){
        return $this->hasMany('App\Models\DataModels\DataOrderLogisticsInfo','order_id','id');
    }
    
    public function belongsToProject(){
        return $this->belongsTo('App\Models\DataModels\DataUserProject','project_id','id');
    }
}

