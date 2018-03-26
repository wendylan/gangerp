<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\Steel_factory;
use App\Models\DataModels\DataWebPrice;
use App\Models\DataModels\DataWebPriceDate;
use App\Models\DataModels\DataMarketDatas;
use App\Models\DataModels\DataMarketDatasChild;
use App\Models\DataModels\DataProject;
use App\Models\DataModels\DataProjectSettlement;
use App\Http\Controllers\v1\DataProjectController;
use App\Models\Company;
use Carbon\Carbon;

class UserDealPageController extends DataProjectController{

    public function getLastPriceDatas(Company $Company){
        $mainMarketPriceDatas = DataMarketDatas::getDataNewly();
        $webPriceDatas = DataWebPriceDate::getWebPriceNewly();
        $mergeDatas = $this->combineWebMarketPrice($webPriceDatas, $mainMarketPriceDatas);
        // $mergeDatas = $this->getMinPrice($mergeDatas);

        $companys = $Company->getAgentCompanys();
        $projectDatas = parent::getUserProject() ?  : [];
        return view('SteelData/UserDeal', ['resultDatas'=>['megerDatas'=>$mergeDatas, 'projectDatas'=>$projectDatas, 'agentCompanys'=>$companys, 'nameList'=>Steel_factory::all()->toArray()]]);
    }

    public function combineWebMarketPrice($webPrice, $marketPrice){
        $todayDate = Carbon::today();
        $todayTimestamp = Carbon::parse($todayDate)->timestamp;
        // 判断最新价格是否当天的价格
        if($marketPrice['created_at'] < $todayDate){
            $marketPrice = [];
        }
        if($webPrice['date'] < $todayTimestamp){
            $webPrice = [];
        }

        // 如果最新网价和市场价都不是今天发布, 那么今天没有发布任何价格
        if(count($webPrice)==0 && count($marketPrice)==0){
            return [];
        }
        
        // 如果网价和市场价只发布了其一, 那么在此简单整合返回
        if(count($webPrice)==0 || count($marketPrice)==0){
            $combineDatas = count($webPrice)==0 ? $marketPrice->getPrice()->get()->toArray() : $webPrice->getPrice()->get()->toArray();
            foreach ($combineDatas as $key => $value) {
                $combineDatas[$key]['cate_spec'] = isset($combineDatas[$key]['product']) ? $combineDatas[$key]['product'] : $combineDatas[$key]['cate_spec'];
                $combineDatas[$key]['size'] = isset($combineDatas[$key]['type']) ? $combineDatas[$key]['type'] : $combineDatas[$key]['size'];
                $combineDatas[$key]['price'] = isset($combineDatas[$key]['price']) ? $combineDatas[$key]['price'] : 0;
                $combineDatas[$key]['web_price'] = isset($combineDatas[$key]['web_price']) ? $combineDatas[$key]['web_price'] : 0;
            }
            return $combineDatas;
        }

        // 网价和市场价在今天都有最新的发布
        if(count($webPrice)!=0 && count($marketPrice)!=0){
            // 合并前预处理网价的键名, 别名
            $elseNameList = Steel_factory::all()->toArray();
            $webPriceList = $webPrice->getPrice()->get();
            $marketPriceList = collect($this->getMinPrice($marketPrice->getPrice()->get()));
            // 处理别名
            $webPriceList->map(function($item, $key) use($elseNameList){
                foreach ($elseNameList as $key => $value) {
                    if($item->brands == $value['full_name']){
                        $item->brand = $value['abbreviation'];
                    }else{
                        $item->brand = $item->brands;
                    }
                }
                // 简单处理键名
                $item->cate_spec = $item->product;
                $item->size = $item->type;
                unset($item->brands);
                unset($item->product);
                unset($item->type);
                return $item;
            });

            //整合网价和市场价
            $longDatas = count($webPriceList) > count($marketPriceList) ? $webPriceList : $marketPriceList;
            $shortDatas = count($webPriceList) > count($marketPriceList) ? $marketPriceList : $webPriceList;
            $resultDatas = [];
            $count = 0;
            foreach ($longDatas as $key => $value) {
                $hasMerge = false;
                foreach ($shortDatas as $index => $val) {
                    if(
                        $value->brand == $val->brand && 
                        $value->cate_spec == $val->cate_spec && 
                        $value->material == $val->material && 
                        $value->size == $val->size
                    ){
                        $resultDatas[] = collect($value)->merge($val);
                        $shortDatas->pull($index);
                        $hasMerge = true;
                    }
                }
                if($hasMerge != false){
                    $longDatas->pull($key);
                }
            }
            return collect($resultDatas)->merge($longDatas)->merge($shortDatas);
        }

    }

    public function getPriceDatasByDate(Request $Request){
        $selectedDate = substr($Request->date, 0, 10).' 00:00:00';
        $mainMarketPriceDatas = DataMarketDatas::getMarketDatasFromDate($selectedDate);
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

    public function addProject(Request $Request){
        $formDatas = $Request->all();
        if(parent::add($formDatas)){
            return $this->responseBuild(parent::getUserProject());
        }else{
            $this->response->error('操作失败', 500);
        }
    }

    public function getSettlementInfo(Request $Request){
        $rule = DataProjectSettlement::where('project_info_id', $Request->id)->select('reference', 'brand', 'specification', 'count_number', 'freight', 'funds_rate', 'ponderation', 'crane')->get();
        return $this->responseBuild($rule);
    }

}
