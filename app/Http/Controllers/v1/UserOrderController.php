<?php
namespace App\Http\Controllers\v1;
use DB;
use Excel;
use ZipArchive;
use Illuminate\Http\Request;
use App\Models\DataModels\DataProject;
use App\Models\DataModels\DataProjectInfo;
use App\Models\DataModels\DataUserOrders;
use App\Models\DataModels\DataUserOrdersDetail;
use App\Models\DataModels\DataUserCarInfo;
use App\Models\Company;

use Auth;
class UserOrderController extends BaseController{
    protected $project;
    protected $order;
    protected $car_info;
    public function __construct( DataProject $project , DataUserOrders $order , DataUserCarInfo $car_info ){
        $this->project = $project ;
        $this->order = $order ;
        $this->car_info = $car_info ;
    }


    //终端订单api
    public function getPurcharOrder(){
        $order = $this->order->getPurcharOrder()->sortByDesc('id');
        $data = [];
        foreach ($order as $key => $value) {
            $data []= $value;
        }
        return collect($data);
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

    public function getUserStOrder(){
        $userOrder = $this->order->getUserStOrder(Auth::user()->id);
        return $userOrder ;
    }

    public function getStOrder(){
        $order = $this->order->getStAllOrder()->sortByDesc('id');
        $data = [];
        foreach ($order as $key => $value) {
            $data []= $value;
        }
        return collect($data);
    }

    public function saveOrder(Request $req){
        $order = $req->input();
        $this->car_info->saveInfo($order);
        $order = $this->orderFormat($order);
        $result = $this->order->saveOrder($order);
        return  $this->responseBuild(1);
    }

    public function serviceSaveOrder(Request $req){
        if($req->data){
            $order = $this->planeOrderFormat($req->data,$req->project_id);
            $order = $this->serviceOrderFormat($order,$req->project_id);
            $result = $this->order->saveOrder($order);
            return  $this->responseBuild('发送成功');
        }
        return  $this->response->error('无数据输入',500);
    }

    public function savePlanOrder(Request $req){
        if($req->data){
            $order = $this->planeOrderFormat($req->data,$req->project_id);
            $order = $this->orderFormat($order);
            $result = $this->order->saveOrder($order);
            sys_notify($req->supplier_id,'s_neworder');
            return  $this->responseBuild('发送成功');
        }
        return  $this->response->error('无数据输入',500);
    }
    public function updateOrder(Request $req){
        // dd($req->input());
        $order = $req->input();
        $this->car_info->saveInfo($order);
        $order = $this->order->updateOrder($order);
        return $order;
    }
    public function memoryOrder(Request $req){
        $order = $req->input();
        $this->car_info->saveInfo($order);
        $order = $this->order->memoryOrder($order);
        return $order;
    }
    public function sendForReceived(Request $req){
        $order = $req->input();
        $this->car_info->saveInfo($order);
        $order = $this->order->sendForReceived($order);
        return $order;
    }

    public function orderPurcharSendService(Request $req){
        $order = $req->input();
        $this->car_info->saveInfo($order);
        $order = $this->order->orderPurcharSendService($order);
        return $order;
    }

    public function confirmReceived(Request $req){
        $order = $req->input();
        $this->car_info->saveInfo($order);
        $order = $this->order->confirmReceived($order);
        return $order;
    }

    public function resendOrder(Request $req){
        $order = $req->input();
        $this->car_info->saveInfo($order);
        $order = $this->order->resendOrder($order);
        return $order;
    }
    public function sendForPurchar(Request $req){
        $order = $req->input();
        $this->car_info->saveInfo($order);
        $order = $this->order->keepOrder($order);
        return $order;
    }
    public function orderPurcharSave(Request $req){
        $order = $req->input();
        $this->car_info->saveInfo($order);
        $order = $this->order->orderPurcharSave($order);
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
    public function deleteOrder(Request $req){
        $data = $req->input();
        $order = $this->order->deleteOrder($data);
        return $this->responseBuild('success');
    }
    public function getOrderHistoryInfo(Request $req){
        $data = $req->input();
        $order = $this->order->getOrderHistoryInfo($data);
        $car_info = $this->car_info->getCardInfo();
        return array('receiverInfo'=>$order,'driverInfo'=>$car_info);
    }
    // 到货时间
    public function receivedTime(Request $req){
        $data = $req->input();
        $order = $this->order->receivedTime($data);
        return $order;
    }

    public function orderFormat($order){
        if(!array_key_exists('project_id',$order)){
            $this->response->error('请选择项目！',500);
        }
        $project_id = $order['project_id'];
        $project = DataProject::where('project_info_id',$project_id)->get();
        if($project->count()){
            if($project[0]->supplier_id==-1){
                $this->response->error('请绑定项目到次终端',500);
            }
            $order['seller_id'] = $project[0]->supplier_id;
            if($project[0]->user_id==-1){
                $this->response->error('请绑定终端账号',500);
            }
            $order['user_id'] = $project[0]->user_id;
        }
        $order['order_number'] = date('Ymd');
        $order['status'] = 0;
        $detail = [];
        foreach ($order['detailOrder'] as $key => $value) {
            $value['unit_price'] =$value['price'];
            unset($value['price']);
            $detail[]=$value;
        }
        $order['detailOrder']=$detail;
        $order['all_total'] = $this->order->getAllTotal($order['detailOrder']);
        $order['count_total'] = $this->order->getCountTotal($order['detailOrder']);
        return $order;
    }

    public function serviceOrderFormat($order,$project_id){
        if(!$project_id){
            $this->response->error('请绑定项目！',500);
        }
        $project = DataProject::where('project_info_id',$project_id)->get();
        if($project->count()){
            if($project[0]->user_id==-1){
                $this->response->error('请绑定终端账号',500);
            }
            $order['user_id'] = $project[0]->user_id;
            if($project[0]->supplier_id==-1){
                $this->response->error('请绑定项目到次终端',500);
            }
            $order['seller_id'] = $project[0]->supplier_id;
        }
        $order['order_number'] = date('Ymd');
        $order['status'] = 0;
        $detail = [];
        foreach ($order['detailOrder'] as $key => $value) {
            $value['unit_price'] =$value['price'];
            unset($value['price']);
            $detail[]=$value;
        }
        $order['detailOrder']=$detail;
        $order['all_total'] = $this->order->getAllTotal($order['detailOrder']);
        $order['count_total'] = $this->order->getCountTotal($order['detailOrder']);
        return $order;
    }

    public function planeOrderFormat($data,$project_id){
        if(!$project_id){
            $this->response->error('请选择项目！',500);
        }
        $project = DataProjectInfo::find($project_id);
        $info = json_decode($project->handlers);
        if(!$info){
            $this->response->error('请完善项目经办人信息！',500);
        }
        $receivers = json_decode($project->receivers);
        $adds = $project->province.$project->city.$project->area.$project->addr;
        // dd($receivers);
        $order = array('detailOrder'=>[],'car_info_change'=>0,'logistics_info'=>[],'transport_function'=>0,
                        'receiver'=>$receivers[0]->receiver,'receiver_tel'=>$receivers[0]->receiver_tel,
                        'date_of_receipt'=>'','place_of_receipt'=>$adds,'order_bussiness_info'=>[],
                        'project_id'=>$project_id);
        // dd(($info->buyer[0]['handler']));
        $order['order_bussiness_info'] = [];
        if($info->buyer){
            // dd(($info->buyer));
            $order['order_bussiness_info']['buyer_name'] = $info->buyer[0]->handler;
            $order['order_bussiness_info']['buyer_fax'] = $info->buyer[0]->handler_fax;
        }else{
            $order['order_bussiness_info']['buyer_name'] = null;
            $order['order_bussiness_info']['buyer_fax'] = null;
        }
        // dd( typeof($info));
        foreach ($data as $key => $value) {
            $order['detailOrder'][]=array(
                'market_price_id' => null,
                'unit_price' => null,
                'amount' => $value['value'],
                'total' => null,
                'brand' => null,
                'cate_spec' => $value['spec'],
                'material' => $value['material'],
                'freight' => null,
                'size' => $value['size'],
                'price' => null,
                'warehouse' => null,
                'plate_num' => null,
                'id' => null
            );
        }
        // dd($order);
        return $order;
    }
    public function formatStOrder($order){
        // $project = DataProject::where('project_info_id',$project_id)->get();
        // dd($order);
        $order['user_id'] = Auth::user()->id;
        $order['order_number'] = date('Ymd');
        $order['status'] = 0;
        $detail = [];
        foreach ($order['detailOrder'] as $key => $value) {
            $value['unit_price'] = $value['price'];
            unset($value['price']);
            $detail[]=$value;
        }
        $order['detailOrder']=$detail;
        $order['all_total'] = $this->order->getAllTotal($order['detailOrder']);
        $order['count_total'] = $this->order->getCountTotal($order['detailOrder']);
        $order['order_type'] = 1;
        $order['order_bussiness_info'] = [];
        $order['order_bussiness_info']['buyer_name'] = Auth::user()->name;
        $order['order_bussiness_info']['buyer_fax'] = Auth::user()->mobile;
        $data = [];
        foreach ($order['logistics_info'] as $key => $value) {
            $count = 0;
            foreach ($value as $vKey => $vValue) {
                if($vValue == ''){
                    $count = $count + 1;
                }
            }
            if($count!=4){
                $data[] = $value;
            }
        }
        $order['logistics_info'] = $data;
        return $order;
    }

    public function getUserCompanyInfo(){
        return Company::getUserBussinessInfo(Auth::user()->id)[0]->name;
    }

    //次中端订单api

    public function saveStOrder(Request $req){
        $order = $req->input();
        $this->car_info->saveInfo($order);
        $order = $this->formatStOrder($order);
        $result = $this->order->stSaveOrder($order);
        return  $this->responseBuild(1);
    }

    // 导出订单excle
    public function exportExcel($dateRange){
        //获取日期内的orders数据
        $orders = [];
        $_orders = $this->order->getOrderByDateRange($dateRange, Auth::id());
        if(count($_orders) === 0){
            return "该日期范围内无任何订单";
        }

        // 获取生成excel所需订单数据
        $excelDatas = $this->makeExcelDatas($_orders);
        $excelHead = $excelDatas['excelHead'];
        $orders = $excelDatas['excelBody'];

        // 生成excel
        foreach ($orders as $key => $value) {
            Excel::create($value['orderName'], function($excel)use($value, $excelHead){
                $excel->sheet('Sheetname', function($sheet)use($value, $excelHead) {
                    $sheet->setWidth('A', 10);
                    $sheet->row(1, $excelHead);
                    $sheet->rows($value['detailDatas']);
                    $sheet->cells('A1:N1', function($cells) {
                        $cells->setAlignment('center');
                        $cells->setFontWeight('bold');
                        $cells->setFontSize(14);
                    });
                    $sheet->cells('A2:N'.(count($value['detailDatas'])+1), function($cells) {
                        $cells->setAlignment('center');
                    });
                });
            })->store('xls', public_path('excel/'));
        }

        // 返回excel
        $zipHandler = new ZipArchive;
        $path = public_path('excel/');
        if($zipHandler->open($path.'package.zip', ZipArchive::CREATE|ZipArchive::OVERWRITE) === true){
            foreach ($orders as $key => $value) {
                $zipHandler->addFile($path.$value['orderName'].'.xls', $value['orderName'].'.xls');
            }
        }
        $zipHandler->close();
        return response()->download($path.'package.zip');
    }

    // 获取构造excel所需的数据
    public function makeExcelDatas($_orders){
        // excel头
        $excelHead = [
            '品牌', '品名', '规格', '材质', '仓库', '成本运费', '运费', '含税单价', '价格',
            '出仓数量', '收货数量', '吨数', '总数', '备注'
        ];
        // 获取orders数据，并删除不需要的字段
        $orders = [];
        foreach ($_orders as $key => $value) {
            // 订单处于已完成的状态的
            if( $value->status==5 ){
                $datasByDetail = ['orderName' => $value->order_number, 'detailDatas' => $value->hasManyOrderDetail->toArray()];
                foreach ($datasByDetail['detailDatas'] as $index => $val) {
                    unset(
                        $datasByDetail[$index]['id'],
                        $datasByDetail[$index]['order_id'],
                        $datasByDetail[$index]['menu'],
                        $datasByDetail[$index]['market_price_id'],
                        $datasByDetail[$index]['plate_num'],
                        $datasByDetail[$index]['created_at'],
                        $datasByDetail[$index]['updated_at'],
                        $datasByDetail[$index]['deleted_at']
                    );
                }
                $orders[] = $datasByDetail;
            }
        }
        return ['excelHead' => $excelHead, 'excelBody' => $orders];
    }

}
