<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\DataModels\DataUserProject;
use App\Models\DataModels\DataUserOrders;
use App\Models\DataModels\DataUserOrdersDetail;
use Auth;
class UserOrderController extends BaseController{
    protected $project;
    protected $order;
    public function __construct( DataUserProject $project , DataUserOrders $order ){
        $this->project = $project ;
        $this->order = $order ;
    }

    public function getUserOrder(){
        $userOrder = $this->order->getUserOrder(Auth::user()->id);
        return $userOrder ;
    } 


    public function getOrder(){
        $order = $this->order->getAllOrder()->sortByDesc('id');
        $data = [];
        foreach ($order as $key => $value) {
            $data []= $value;
        }
        return collect($data);
    }

    public function saveOrder(Request $req){
        $order = $req->input();
        $order = $this->orderFormat($order);
        $result = $this->order->saveOrder($order);
        return  $this->responseBuild(1);
    }
    public function updateOrder(Request $req){
        $order = $req->input();
        $order = $this->order->updateOrder($order);
        return $order;
    }
    public function cancelOrder(Request $req){
        $data = $req->input();
        $order = $this->order->cancelOrder($data);
        return $order;
    }
    public function finishOrder(Request $req){
        $data = $req->input();
        $order = $this->order->finishOrder($data);
        return $order;
    }
    public function resendOrder(Request $req){
        $data = $req->input();
        $order = $this->order->resendOrder($data);
        return $order;
    }
    public function deleteOrder(Request $req){
        $data = $req->input();
        $order = $this->order->deleteOrder($data);
        return $this->responseBuild('success');
    }
    public function orderFormat($order){
        $order['user_id'] = Auth::user()->id;
        $order['order_number'] = date('Ymd');
        $order['status'] = 0;
        $order['all_total'] = $this->order->getAllTotal($order['detailOrder']);
        $order['count_total'] = $this->order->getCountTotal($order['detailOrder']);
        return $order;
    }
}