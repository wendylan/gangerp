<?php 
namespace App\Http\Controllers\v1;
use Log;
use DB;
use URL;
use Illuminate\Http\Request;
use App\Models\DataModels\DataMarketDatasChild;
use App\Models\DataModels\DataMarketDatas;
use App\Models\DataModels\DataWebPriceDate;
use App\Models\DataModels\DataWebPrice;
use App\Models\DataModels\DataTransport;
class SoptPricePageController extends MarketDataHandleController{
	protected $dataMarketDatasChild;
	protected $dataMarketDatas;
	public function __construct(DataMarketDatasChild $dataMarketDatasChild , DataMarketDatas $dataMarketDatas){
		$this->dataMarketDatasChild = $dataMarketDatasChild ;
	}

	public function getSoptPriceByDate(Request $req){
		$date = $req->date;
		if(!$req->date){
			$date = date('Y-m-d');
		}
		$data = $this->dataMarketDatasChild->getMarketPriceByDate($date);
		$data = $this->getMinPrice($data);
		return $data ;
	}
	//现货价格指数
	public function getSoptPrice(Request $req){
		$date = $req->date;
		$isByDate = 0;
		if(!$date){
			$isByDate = 1;
			$date = DataMarketDatas::getLastDateHasData();
		}
		$webData = $this->getWebPriceByDate($date);

		$group = DataMarketDatas::getMarketDatasFromDate($date)->where('display',1);
		$times = $this->getTimes($group);
		$returndata=[];
		foreach ($group as $key => $value) {
			$value->childDatas = $value->childDatas->sortBy('price');
			$dataSortByPrice = [];
			foreach ($value->childDatas as $skey => $svalue) {
				$dataSortByPrice[]= $svalue;
			}
			$value->childDatas = $dataSortByPrice;
			$minData=$this->getMinPrice($value->childDatas);
			$returndata[] = $minData;
			
		}
		$brands = [];
		if(count($returndata)){
			foreach ($returndata as $key => $value) {
				$brands []= $this->getDataBrands($value);
			}
		}
		$returndata = array('soptPrice'=>$returndata,'times'=>$times,'webprice'=>$webData,'date'=>$date,'brands'=>$brands);
		return $this->responseBuild($returndata);
	}
	//买买买
	public function getPurchaseSpotPrice(Request $req){
		$date = $req->date;
		$isByDate = 0;
		if(!$date){
			$isByDate = 1;
			$date = DataMarketDatas::getLastDateHasData();
		}
		$webData = $this->getWebPriceByDate($date);

		$group = DataMarketDatas::getMarketDatasFromDate($date)->where('display',1);
		$times = $this->getTimes($group);
		$maindata=[];
		foreach ($group as $key => $value) {
			$value->childDatas = $value->childDatas->sortBy('price');
			$dataSortByPrice = [];
			foreach ($value->childDatas as $skey => $svalue) {
				$dataSortByPrice[]= $svalue;
			}
			$value->childDatas = $dataSortByPrice;
			$minData=$this->getPurchaseMinPrice($value->childDatas);
			$maindata[] = $this->getEqualPriceItem($minData,$value->childDatas);
			
		}
		$brands = [];
		if(count($maindata)){
			foreach ($maindata as $key => $value) {
				$brands []= $this->getDataBrands($value);
			}
		}
		$returndata = array('soptPrice'=>$maindata,'times'=>$times,'webprice'=>$webData,'date'=>$date,'brands'=>$brands);
		return $this->responseBuild($returndata);
	}

	public function getAllSoptPrice(Request $req){
		$data = [];
		$adds = $req->adds;
		$date = date('Y-m-d');
		$webData = $this->getWebPriceByDate($date);
		$group = $this->getMarketPriceByDate($date);
		$freight = $this->getFreight($adds);
		if ((count($group))>0) {
			$data = $this->spotPriceComeWebPrice($group[count($group)-1]->childDatas,$webData,$freight);
		}
		$data = collect($data)->sortBy('price');
		$dataSortByPrice = [];
		foreach ($data as $key => $value) {
			$dataSortByPrice[]= $value;
		}
		$data = $dataSortByPrice;
		$brands = $this->getDataBrands($data);
		$data = $this->sortByBrand($brands,$data);
		$allPriceSource = DB::select('select * from data_price_source');
		$data = $this->replacePriceSource($data, $allPriceSource);
		return array('soptPrice'=>$data,'date'=>$date);
		
	}
	public function getFreight($adds){
		$city = $adds['city'];
		$area = $adds['area'];
		$freight = $freightInfo = DataTransport::where('city',$city)->where('area',$area)->get();
		$mill = $freightInfo->where('type',2)->unique('transport_price','brand')->groupBy('brand');
        foreach ($mill as $key => $value) {
            $mill[$key]=$value->max('transport_price');
        }
        $warehouse = $freightInfo->where('type',1)->max('transport_price');
        return array('mill'=>$mill,'warehouse'=>$warehouse);
	}
	public function getMarketPriceByDate($date){
		return  DataMarketDatas::getMarketDatasFromDate($date)->where('display',1);
	}
	public function spotPriceComeWebPrice($sopt,$web,$freight){
		$data = [];
		foreach ($sopt as $skey => $svalue) {
			$door = 1;
			foreach ($web as $wkey => $wvalue) {
				// Log::info($value->file_name);
				if(
					$svalue->size==$wvalue->type&&
					$this->isBrandEqual($svalue->brand,$wvalue->brands)&&
					$svalue->material==$wvalue->material&&
					$svalue->cate_spec==$wvalue->product
				){
					$svalue->web_price = $wvalue->web_price;
					$data[] = $svalue;
					$door = 0;
					break;		
				}
			}

			$svalue->freight = null;
			if($svalue->transport=='广州仓发货'){
				if($freight['warehouse']){
					 $svalue->freight = $freight['warehouse'];
				}
			}else if($svalue->transport=='直送'){
				foreach ($freight['mill'] as $key => $value) {
					if($this->isBrandEqual($svalue->brand,$key)){
						$svalue->freight = $value;
						break;
					}
				}
			}
			if($door){
				$svalue->web_price = 0;
				$data[] = $svalue;
			}
		}
		return $data;
	}
	public function getWebPriceByDate($date){
    	$time=strtotime($date);
    	$timeend=$time+86400;
    	$date=DataWebPriceDate::whereBetween('date', [$time, $timeend])->get();
    	$date=$date->max('date');
    	$data=DataWebPrice::where('file_name',$date)->get();
    	return $data;
    }


	public function getDataBrands($data){
		$data = collect($data)->groupBy('brand');
		$returnData = [];
		foreach ($data  as $key => $value) {
			$returnData[]=$key;
		}
		return $returnData;
	}
	public function getTimes($data){
		$times = [];
		foreach ($data as $key => $value) {
			$time = date('H:i:s',$value->updated_at->getTimestamp());
			$times[]=$time;
		}
		return $times;
	}
	public function sortByBrand($brands,$data){
		$returndata = [];
		foreach ($brands as $key => $value) {
			foreach ($data as $dkey => $dvalue) {
				if($value == $dvalue->brand){
					$returndata[]=$dvalue;
				}
			}
		}
		return $returndata;
	}

	public function replacePriceSource($data, $allPriceSource){
		$returndata = [];
		foreach ($data as $dkey => $dvalue) {
			foreach ($allPriceSource as $pkey => $pvalue) {
				if($dvalue->price_source == $pvalue->name){
					if($pvalue->short_name != null){
						$dvalue->price_source = $pvalue->short_name;
					}
					$returndata[]=$dvalue;
				}
			}
		}
		return $returndata;
	}
}

?>