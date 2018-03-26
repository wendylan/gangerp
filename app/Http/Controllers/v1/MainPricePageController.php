<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\Steel_factory;
use App\Models\DataModels\DataWebPrice;
use App\Models\DataModels\DataWebPriceDate;
use App\Models\DataModels\DataMarketDatas;
use App\Models\DataModels\DataMarketDatasChild;

class MainPricePageController extends BaseController{

    public function getLastMainDatas(){
        $lastMarketReport = DataMarketDatas::where('display','=',1)->get()->last();
        $lastDay = substr($lastMarketReport->created_at, 0, 10).' 00:00:00';
        $mainMarketPriceDatas = DataMarketDatas::getMarketDatasFromDate($lastDay)->where('display', 1);
        foreach ($mainMarketPriceDatas as $key => $value) {
        	$value['childDatas'] = $this->getMinPrice(collect($value['childDatas']));
        }
        $webPriceDatas = (new DataWebPriceDate)->getWebPriceByDate($lastDay, true);
        return view('SteelData/SteelMainPrice', ['resultDatas'=>['marketPriceDatas'=>$mainMarketPriceDatas, 'webPriceDatas'=> $webPriceDatas, 'nameList'=>Steel_factory::all()->toArray()]]);
    }

    public function getMainDatasByDate(Request $Request){
        $selectedDate = substr($Request->date, 0, 10).' 00:00:00';
        $mainMarketPriceDatas = DataMarketDatas::getMarketDatasFromDate($selectedDate)->where('display', 1);
        foreach ($mainMarketPriceDatas as $key => $value) {
            $value['childDatas'] = $this->getMinPrice(collect($value['childDatas']));
        }
        $webPriceDatas = (new DataWebPriceDate)->getWebPriceByDate($selectedDate, true);
        if(count($mainMarketPriceDatas)){
            return $this->responseBuild(['marketPriceDatas'=>$mainMarketPriceDatas, 'webPriceDatas'=> $webPriceDatas]);
        }else{
            $this->response->error('当天没有现货价数据', 500);
        }
    }

}
