<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\DataModels\DataWebPrice;
use App\Models\DataModels\DataWebPriceDate;
use App\Models\DataModels\DataMarketDatas;
use App\Models\DataModels\DataMarketDatasChild;
use App\Models\DataModels\DataProject;
use App\Models\DataModels\DataProjectSettlement;
use App\Http\Controllers\v1\DataProjectController;
use App\Models\Company;

class UserDealPageController extends DataProjectController{

    public function getLastPriceDatas(Company $Company){
        $lastWebReport = DataWebPriceDate::get()->last();
        $lastDay = substr(date('Y-m-d', $lastWebReport->date), 0, 10).' 00:00:00';
        $mainMarketPriceDatas = DataMarketDatas::getMarketDatasFromDate($lastDay);
        foreach ($mainMarketPriceDatas as $key => $value) {
            $value['childDatas'] = $this->getMinPrice(collect($value['childDatas']));
        }
        $webPriceDatas = (new DataWebPriceDate)->getWebPriceByDate($lastDay, true);
        $companys = $Company->getAgentCompanys();
        return view('SteelData/UserDeal', ['resultDatas'=>['marketPriceDatas'=>$mainMarketPriceDatas, 'webPriceDatas'=> $webPriceDatas, 'projectDatas'=>parent::getUserProject(), 'agentCompanys'=>$companys]]);
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

    public function tempGetLastPriceDatas(){
        $lastMarketReport = DataMarketDatas::get()->last();
        $lastDay = substr($lastMarketReport->created_at, 0, 10).' 00:00:00';
        $mainMarketPriceDatas = DataMarketDatas::getMarketDatasFromDate($lastDay);
        $webPriceDatas = (new DataWebPriceDate)->getWebPriceByDate($lastDay, true);
        return $this->responseBuild(['resultDatas'=>['marketPriceDatas'=>$mainMarketPriceDatas, 'webPriceDatas'=> $webPriceDatas]]);
    }

}
