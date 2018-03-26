<?php

namespace App\Models\DataModels;
use DB;
use Auth;
use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DataModels\DataUserOrdersDetail;
use App\Models\DataModels\DataOrderLogisticsInfo;
use App\Models\DataModels\DataOrderBussinessInfo;
use App\Models\DataModels\DataUser as User;
use App\Models\DataModels\DataProjectInfo as Project;
use App\Http\Controllers\v1\BaseController;
use App\Models\Steel_factory;
use App\Models\Company;



class DataUserOrders extends Model
{
    use SoftDeletes;

    protected $table = 'data_user_orders';
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function getPurcharOrder(){
        $user_id = Auth::user()->id;
        $allOrder = $this::where('send_for_purchar','>',0)->where('status','<>',-1)->where('order_type',0)->
        where('seller_id',$user_id)->get();
        foreach ($allOrder as $key => $value) {
            $value->orderDetail = $value->getOrderDetialWithMarketPrice($value->id);
            $value->user_name=$this->getUserName($value->user_id);
            $value->project = Project::find($value->project_id);
            if($value->project&&$value->project->brands){
                $data = json_decode($value->project->brands);
                $handleData = [];
                foreach ($data as  $brandkey => $brand_id) {
                    $handleData[]=Steel_factory::find($brand_id)->abbreviation;
                }
                $value->project->brands = $handleData;
                $value->project->settlement = json_decode($value->project->settlement);
            }
            $value->logisticsInfo =  $value->hasManyLogisticsInfo()->get();
            $value->bussinessInfo = $value->hasOneBussinessInfo()->get();
            $value->tradeBetween = $value->getOrderCompanyInfo($value);
        }
        return $allOrder;
    }

    public function getUserOrder( $id ){
        $userOrders = $this::where('user_id','=',$id)->where('order_type',0)->get()->sortByDesc('id');
        foreach ($userOrders as $key => $value) {
            $value->orderDetail = $value->hasManyOrderDetail()->get();
            $value->bussinessInfo = $value->hasOneBussinessInfo()->get();
            $value->logisticsInfo =  $value->hasManyLogisticsInfo()->get();
            $value->tradeBetween = $value->getOrderCompanyInfo($value);
        }
        $data = [];
        foreach ($userOrders as $key => $value) {
            $data []= $value;
        }
        return collect($data);
    }

    public function getAllOrder(){
        $user_id = Auth::user()->id;
        $allOrder = $this::all()->where('status','<>',-1)->where('order_type',0)->where('seller_id',$user_id);
        foreach ($allOrder as $key => $value) {
            $value->orderDetail = $value->hasManyOrderDetail()->get();
            $value->user_name=$this->getUserName($value->user_id);
            $value->project = Project::find($value->project_id);
            if($value->project&&$value->project->brands){
                $data = json_decode($value->project->brands);
                $handleData = [];
                foreach ($data as  $brandkey => $brand_id) {
                    $handleData[]=Steel_factory::find($brand_id)->abbreviation;
                }
                $value->project->brands = $handleData;
                $value->project->settlement = json_decode($value->project->settlement);
            }
            $value->logisticsInfo =  $value->hasManyLogisticsInfo()->get();
            $value->bussinessInfo = $value->hasOneBussinessInfo()->get();
            $value->tradeBetween = $value->getOrderCompanyInfo($value);
        }
        return $allOrder;
    }

    public function getStAllOrder(){
        $allOrder = $this::where('status','<>',-1)->where('order_type',1)->get();
        foreach ($allOrder as $key => $value) {
            $value->orderDetail = $value->getOrderDetialWithMarketPrice($value->id);
            $value->user_name = $this->getUserName($value->user_id);
            $value->logisticsInfo =  $value->hasManyLogisticsInfo()->get();
            $value->bussinessInfo = $value->hasOneBussinessInfo()->get();
            $value->tradeBetween = $value->getOrderCompanyInfo($value);
        }
        $order = $allOrder->sortByDesc('id');
        $data = [];
        foreach ($order as $key => $value) {
            $data []= $value;
        }
        return collect($data);
    }

    public function getUserStOrder($id){
        $userOrders = $this::where('user_id','=',$id)->where('order_type',1)->get()->sortByDesc('id');
        foreach ($userOrders as $key => $value) {
            $value->orderDetail = $value->hasManyOrderDetail()->get();
            $value->bussinessInfo = $value->hasOneBussinessInfo()->get();
            $value->logisticsInfo =  $value->hasManyLogisticsInfo()->get();
            $value->tradeBetween = $value->getOrderCompanyInfo($value);
        }
        $data = [];
        foreach ($userOrders as $key => $value) {
            $data []= $value;
        }
        return collect($data);
    }
    public function getOrderCompanyInfo($order){
        $returndata = [];
        if($order->order_type){
            $returndata['buyercompany'] = '';
            $buyercompany = Company::where('user_id',$order->user_id)->get();
            if(count($buyercompany)){
                $returndata['buyercompany'] = $buyercompany[0]->name;
            }
            $returndata['sellcompany'] = '广东广物供应链管理有限公司';
            return $returndata;
        }
        $project_info_id = $order->project_id;
        $project = DataProject::where('project_info_id',$project_info_id)->get();
        if(!count($project)){
            return [];
        }
        $buyer_id = $project[0]->user_id;
        $buyercompany = Company::where('user_id',$buyer_id)->get();
        if(!count($buyercompany)){
            $returndata['buyercompany'] = '';
        }else{
            $returndata['buyercompany'] = $buyercompany[0]->name;
        }
        $seller_id = $project[0]->supplier_id;
        $sellcompany = Company::where('user_id',$seller_id)->get();
        if(!count($sellcompany)){
            $returndata['sellcompany'] = '';
        }else{
            $returndata['sellcompany'] = $sellcompany[0]->name;
        }
        return $returndata;
    }
    public function keepOrder($data){
        $order = $this::find($data['id']);
        if($order->status == 0){
            $order->status = 1;
        }
        $order->send_for_purchar = 1;
        return $this->updateOrderForPurchar($data,$order);
    }

    public function orderPurcharSave($data){
        $order = $this::find($data['id']);
        // $order->send_for_purchar = 2;
        return $this->updateOrderForPurchar($data,$order);
    }

    public function orderPurcharSendService($data){
        $order = $this::find($data['id']);
        $order->send_for_purchar = 2;
        return $this->updateOrderForPurchar($data,$order);
    }

    public function updateOrderForPurchar($data,$order){
        $order->transport_function = $data['transport_function'];
        $order->all_total = $this->getAllTotal($data['detailOrder']);
        $order->count_total = $this->getCountTotal($data['detailOrder']);
        $order->receiver = $data['receiver'];
        $order->receiver_tel = $data['receiver_tel'];
        $order->date_of_receipt = $data['date_of_receipt'];
        $order->place_of_receipt = $data['place_of_receipt'];
        $order->remarks = $data['remarks'];
        $order->save();
        $order->bussinessInfo =$order->updateBussinessInfo($data['bussinessInfo'],3);
        $order->tradeBetween = $order->getOrderCompanyInfo($order);
        $this->updateOrderDetail($data['detailOrder'],$data['id'],$data['status']);
        $order->orderDetail = $order->getOrderDetialWithMarketPrice($order->id);
        $order->project = Project::find($order->project_id);
        if(array_key_exists('logistics_info',$data)){
            $order->logisticsInfo = $this->updateLogistics($data['logistics_info'],$data['id']);
        }
        $order->user_name=User::find($order->user_id)->name;
        return $order;
    }

    public function memoryOrder($data){
        $order = $this::find($data['id']);
        return $this->orderUpdate($order,$data,$data['status']);
    }

    public function resendOrder($data){
        $order = $this::find($data['id']);
        return $this->orderUpdate($order,$data,0);
    }

    public function cancelOrder($data){
        $order = $this::find($data['id']);
        if(Auth::user()->id == $order->user_id && $order->status>0){
            $this->responseError('卖方以接单，如果要取消订单，请与卖方联系！');
        }
        $order->status = intval($data['status'])*-1;

        $order->save();
        $order->orderDetail = $order->hasManyOrderDetail()->get();
        $order->logisticsInfo = $order->hasManyLogisticsInfo()->get();
        $order->bussinessInfo = DataOrderBussinessInfo::find($data['id']);
        $order->tradeBetween = $order->getOrderCompanyInfo($order);
        $order->user_name=User::find($order->user_id)->name;
        $order->project = Project::find($order->project_id);
        return $order;
    }

    public function deleteOrder($data){
        $order = $this::find($data['id']);
        $order = $order->delete();
        return $order;
    }

    public function updateOrder($data){
        $order = $this::find($data['id']);
        if(!$order->send_for_purchar&&!$order->order_type){
            $order->send_for_purchar = 1;
        }
        return $this->orderUpdate($order,$data,2);
    }

    public function finishOrder($data){
        $order = $this::find($data['id']);
        return $this->orderUpdate($order,$data,3);
    }

    public function sendForReceived($data){
        $order = $this::find($data['id']);
        return $this->orderUpdate($order,$data,4);
    }
    public function confirmReceived($data){
        $order = $this::find($data['id']);
        $order->received_at = date('Y-m-d H:i:s');
        return $this->orderUpdate($order,$data,5);
    }
    // 到货时间
    public function receivedTime($data){
        $order = $this::find($data['id']);
        if($order['status']>=3 && $order['received_at'] == null){
            $time = date('Y-m-d H:i:s');
            $order->received_at = $time;
            $order->status = 5;
            $order->save();
        }
        return $order;
    }

    protected function isInData($data,$id){
        foreach ($data as $key => $value) {
            if($value['id']==$id){
                return true;
            }
        }
        return false;
    }

    public function updateOrderDetail($data, $order_id, $status){
        $orderDetails = [];
        $insertData = [];
        $orderDetailsOld = $this::find($order_id)->hasManyOrderDetail()->get();
        foreach ($orderDetailsOld as $key => $value) {
            if(!$this->isInData($data,$value->id)){
                $value->delete();
            }
        }
        foreach ($data as $key => $value) {
            if(array_key_exists('isPlay',$value)){
                unset($value['isPlay']);
            }
            if(array_key_exists('price_source',$value)){
                unset($value['price_source']);
            }
            if($value['id']){
                $orderDetail = DataUserOrdersDetail::find($value['id']);
                if(array_key_exists('market_price_id',$value)){
                    $orderDetail->market_price_id = $value['market_price_id'];
                }
                if(array_key_exists('freight',$value)){
                    $orderDetail->freight = $value['freight'];
                }
                if(array_key_exists('cost_freight',$value)){
                    $orderDetail->cost_freight = $value['cost_freight'];
                }
                if(array_key_exists('out_warehouse_amount',$value)){
                    $orderDetail->out_warehouse_amount = $value['out_warehouse_amount'];
                }
                if(array_key_exists('received_amount',$value)){
                    $orderDetail->received_amount = $value['received_amount'];
                }
                $orderDetail->brand = $value['brand'];
                $orderDetail->cate_spec = $value['cate_spec'];
                $orderDetail->size = $value['size'];
                $orderDetail->material = $value['material'];
                if(array_key_exists('price',$value)){
                    $orderDetail->price = $value['price'];
                }
                $orderDetail->unit_price = $value['unit_price'];
                $orderDetail->amount = $value['amount'];
                $orderDetail->total = $value['unit_price']*$value['amount'];
                $orderDetail->remark = $value['remark'];
                $orderDetail->plate_num = $value['plate_num'];
                $orderDetail->save();
            }else{
                unset($value['id']);
                if(array_key_exists('allAmount',$value)){
                    unset($value['allAmount']);
                }

                $value['order_id'] = $order_id;
                $insertData []= $value;
            }

            if(intval($value['amount']) < 0){
                $order = $this::find($order_id);
                $order->status = $status;
                $order->save();
                $response = new BaseController();
                $response->response->error('计划吨数不能为空或小于0',500);
            }

        }
        if(count($insertData)){
            $orderDetail = DataUserOrdersDetail::insert($insertData);
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

    public function orderUpdate($order,$data,$status){
        $this->statusJudge($order->status,$status);
        $order->status = $status;
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
        $order->bussinessInfo = $order->updateBussinessInfo($data['bussinessInfo'],$status);
        $order->tradeBetween = $order->getOrderCompanyInfo($order);
        $order->orderDetail = $order->hasManyOrderDetail()->get();
        $order->project = Project::find($order->project_id);
        if(array_key_exists('logistics_info',$data)){
            $order->logisticsInfo = $this->updateLogistics($data['logistics_info'],$data['id']);
        }
        $order->user_name=User::find($order->user_id)->name;
        return $order;
    }
    public function statusJudge($oldStatus,$newStatus){
        if($oldStatus<0&&$newStatus>0){
            $this->responseError('订单已取消!');
        }
    }
    public function responseError($msg){
        $resp = new BaseController();
        $resp->response->error($msg,500);
    }
    public  function saveOrder($data){
        $count = $this::where('project_id',$data['project_id'])->where('created_at','like',date('Y-m-d').'%')->count();
        $project = Project::find($data['project_id']);
        $importentItem = json_decode($project->settlement);
        if($importentItem->priceType == '现货价'){
            $data['price_type'] = 2;
        }else{
            $data['price_type'] = 1;
        }
        $data['order_number'] = $data['order_number'].'-'.$count.$project->name;
        $orderDetail = DataUserOrdersDetail::formatOrderDetail($data['detailOrder']);
        $orderBussinessInfo = $data['order_bussiness_info'];
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
        unset($data['car_info_change']);
        unset($data['logistics_info']);
        unset($data['detailOrder']);
        unset($data['order_bussiness_info']);
        $result = $this::create($data);
        $result->bussinessInfo = $this->saveBussinessInfo($result->id,$orderBussinessInfo);
        $result->detail = $result->saveOrderDetail($result,$orderDetail);
        if($data['transport_function']){
            $result->logistics_info = $result->saveLogisticsInfo($logistics_info);
        }
        return $result;
    }

    public  function stSaveOrder($data){
        $count = $this::where('user_id',Auth::user()->id)->where('created_at','like',date('Y-m-d').'%')->count();
        $company = Company::where('user_id',Auth::user()->id)->get();
        if(!count($company)){
            $response = new BaseController();
            $response->response->error('请完善企业信息',500);
        }
        $data['order_number'] = $data['order_number'].'-'.$count.$company[0]->name;
        $orderDetail = DataUserOrdersDetail::formatStOrderDetail($data['detailOrder']);
        $orderBussinessInfo = $data['order_bussiness_info'];
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
        unset($data['car_info_change']);
        unset($data['logistics_info']);
        unset($data['detailOrder']);
        unset($data['order_bussiness_info']);
        $result = $this::create($data);
        $result->bussinessInfo = $this->saveBussinessInfo($result->id,$orderBussinessInfo);
        $result->detail = $result->saveOrderDetail($result,$orderDetail);
        if($data['transport_function']){
            $result->logistics_info = $result->saveLogisticsInfo($logistics_info);
        }
        return $result;
    }

    public function saveBussinessInfo($order_id,$data){
        $bussinessInfo = new DataOrderBussinessInfo();
        $bussinessInfo->order_id = $order_id;
        $bussinessInfo->buyer_name = $data['buyer_name'];
        $bussinessInfo->buyer_fax = $data['buyer_fax'];
        $bussinessInfo->buyer_id = Auth::user()->id;
        $bussinessInfo->updated_at = null;
        $bussinessInfo->date_create = date('Y-m-d');
        $bussinessInfo->save();
        return $bussinessInfo;
    }
    public function updateBussinessInfo($data,$status){
        // dd($data);
        $bussinessInfo = DataOrderBussinessInfo::find($data['id']);
        if(!$bussinessInfo->date_handle){
            $bussinessInfo->date_handle = date('Y-m-d');
        }
        if($status==2&&!$bussinessInfo->seller_id){
            $bussinessInfo->seller_id = Auth::user()->id;
        }
        $bussinessInfo->buyer_name = $data['buyer_name'];
        $bussinessInfo->buyer_fax = $data['buyer_fax'];
        $bussinessInfo->seller_name = $data['seller_name'];
        $bussinessInfo->seller_fax = $data['seller_fax'];
        $bussinessInfo->save();
        return $bussinessInfo;
    }

    public function saveOrderDetail($order,$data){
        $orderDetail = [];
        foreach ($data as $key => $value) {
            if($order->transport_function=="1"&&$value['warehouse']!="钢厂直送"){
                $value['freight'] = 0;
            }if($order->order_type==0){
                $value['freight'] = null;
                $value['warehouse'] = null;
            }
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
            $all_total+=$num*$value['unit_price'];
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

    public function hasManyOrderDetail(){
        return $this->hasMany('App\Models\DataModels\DataUserOrdersDetail','order_id','id');
    }

    //hasmany and belong to
    public function getOrderDetialWithMarketPrice($id){
        return DB::select("select d.* ,a.price_source from data_user_orders_detail as d
                    left join data_market_datas_child a on d.market_price_id = a.id
                    where d.order_id = ?", [$id]);
    }
    public function hasManyLogisticsInfo(){
        return $this->hasMany('App\Models\DataModels\DataOrderLogisticsInfo','order_id','id');
    }

    public function hasOneBussinessInfo(){
        $bussinessInfo=$this->hasOne('App\Models\DataModels\DataOrderBussinessInfo','order_id','id');
        return $bussinessInfo;
    }

    public function belongsToProject(){
        return $this->belongsTo('App\Models\DataModels\DataUserProject','project_id','id');
    }

    public function getOrderHistoryInfo($data){
        $lastOrder = [];
        if(array_key_exists('id',$data)){
            $lastOrder = DataUserOrders::find(
                DataUserOrders::where('project_id',$data['project_id'])->where('id','<',intval($data['id']))->get()->max('id')
            );
        }else{
            $data['id']=$this::all()->max('id')+1;
            $lastOrder = DataUserOrders::find(
                DataUserOrders::where('project_id',$data['project_id'])->where('id','<',intval($data['id']))->get()->max('id')
            );
        }
        return $lastOrder;
    }

    // 获取日期段内所有的订单
    // $accountId可选参数, 可指定某个账户id来获取对应的orders数据
    public function getOrderByDateRange($dateRange, $accountId=false){
        $dateRange = explode(' - ', $dateRange);
        $startDate = $dateRange[0];
        $endDate = $dateRange[1];
        if(!$accountId){
            $result = DataUserOrders::whereDate('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
        }else{
            $result = DataUserOrders::where('user_id', $accountId)
                ->orWhere('seller_id', $accountId)
                ->whereDate('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)->get();
        }
        return $result;
    }

    protected function getUserName($id){
        $user = User::find($id);
        if(!$user){
            return null;
        }
        return $user->name;
    }
}
