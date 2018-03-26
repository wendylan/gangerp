<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\DataModels\DataWebPrice;
use App\Models\DataModels\DataWebPriceDate;
use App\Models\DataModels\DataMarketDatas;
use App\Models\Steel_factory;

class DealingToolController extends BaseController{

    public function index(){
        $lastMarketReport = DataMarketDatas::where('display',1)->get()->last();
        $lastDay = substr($lastMarketReport->created_at, 0, 10).' 00:00:00';
        $mainMarketPriceDatas = DataMarketDatas::getMarketDatasFromDate($lastDay);
        $webPriceDatas = (new DataWebPriceDate)->getWebPriceByDate($lastDay, true);
        return view('SteelData/DealingTool', ['resultDatas'=>['marketPriceDatas'=>$mainMarketPriceDatas, 'webPriceDatas'=> $webPriceDatas, 'nameList'=>Steel_factory::all()->toArray()]]);
    }

}
