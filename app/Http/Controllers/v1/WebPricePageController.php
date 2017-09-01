<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\DataModels\DataWebPrice;
use App\Models\DataModels\DataWebPriceDate;
class WebPricePageController extends BaseController{

    public function getLastDayWebDatas(){
        $lastDate = DataWebPriceDate::get()->last();
        $result = (new DataWebPriceDate)->getWebPriceByDate(substr(date('Y-m-d', $lastDate->date), 0, 10), true);
        return view('SteelData/SteelWebPrice', [ 'webPriceDatas'=>$result ]);
    }

    public function getPriceTimesByDate(Request $Request){
        $result = (new DataWebPriceDate)->getWebPriceByDate(substr($Request->date, 0, 10), true);
        if(count($result)){
            return $this->responseBuild($result);
        }else{
            return $this->response->error('当天没有网价.', 500);
        }
    }

    //template
    public function tempGetLastDatas(){
        // 获取最后一次报价
        $lastDate = DataWebPriceDate::get()->last();

        // 获取最后一次报价当天报价次数
        $theTimestmp = strtotime(date('Y-m-d', $lastDate->date).'00:00:00');
        $reportTimes = DataWebPriceDate::where('date', '>', $theTimestmp)->where('date', '<', $theTimestmp+86400)->get()->toArray();

        $lastDate['reportTimes'] = count($reportTimes);
        $lastDate['childDatas'] = DataWebPrice::where('file_name', $lastDate->date)->get();
        return $lastDate;
    }

}
