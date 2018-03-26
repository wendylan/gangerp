<?php
namespace App\Http\Controllers\v1;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\DataModels\DataProject;
use App\Models\DataModels\DataUserOrders;
use App\Models\DataModels\DataWebPrice;
use App\Models\DataModels\DataMarketDatas;
use App\Models\DataModels\DataMarketDatasChild;
use App\Http\Controllers\v1\DataProjectController;

class SupplierOrderController extends DataProjectController{

    protected $order;
    protected $market;
    protected $web;

    public function __construct(DataUserOrders $dataUserOrders, DataMarketDatas $marketDatas, DataWebPrice $webDatas){
        $this->order = $dataUserOrders;
        $this->market = $marketDatas;
        $this->web = $webDatas;
    }

    public function index(){
        $project = parent::getUserProject();
        $orders = $this->order->getStAllOrder();
        $marketPriceDatas = $this->market->where('display', 1)->first();
        $webPriceDatas = $this->web->getWebPriceFromDate($marketPriceDatas->created_at);
        $marketPriceDatas = ( new DataMarketDatasChild )->getChildDataFromParentId($marketPriceDatas->id);
        return view('SteelData/SupplierOrder', ['resultDatas' => ['projects'=>$project, 'orders'=>$orders, 'webPriceDatas'=>$webPriceDatas, 'marketPriceDatas'=>$marketPriceDatas]]);
    }

}
