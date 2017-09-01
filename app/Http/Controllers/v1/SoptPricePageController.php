<?php 
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\DataModels\DataMarketDatasChild;
use App\Models\DataModels\DataMarketDatas;
use App\Models\DataModels\DataWebPriceDate;
use App\Models\DataModels\DataWebPrice;
class SoptPricePageController extends BaseController{
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
		$data = $this->dataMarketDatasChild->getMarketPriceByDate($date)->where('inventory','有货');
		$data = $this->getMinPrice($data);
		return $data ;
	}

	public function getSoptPrice(Request $req){
		$date = $req->date;
		$isByDate = 0;
		if(!$date){
			$isByDate = 1;
			$date = date('Y-m-d');
		}
		$webData = $this->getWebPriceByDate($date);
		$group = DataMarketDatas::getMarketDatasFromDate($date);
		if ($group->isEmpty()&&$isByDate) {
			$date = DataMarketDatas::getLastDateHasData();
			$webData = $this->getWebPriceByDate($date);
			$group = $this->getLastSoptPrice($date);
		}
		$returndata=[];
		foreach ($group as $key => $value) {
			$returndata[]=$this->getMinPrice($value->childDatas);
		}
		return array('soptPrice'=>$returndata,'webprice'=>$webData,'date'=>$date);
	}

	public function getLastSoptPrice($date){
		return  DataMarketDatas::getMarketDatasFromDate($date);
	}

	public function getWebPriceByDate($date){
    	$time=strtotime($date);
    	$timeend=$time+86400;
    	$date=DataWebPriceDate::whereBetween('date', [$time, $timeend])->get();
    	$date=$date->max('date');
    	$data=DataWebPrice::where('file_name',$date)->get();
    	return $data;
    }
}

?>