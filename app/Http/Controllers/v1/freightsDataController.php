<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\DataModels\DataTransport;
// use App\Models\Bid;
class freightsDataController extends BaseController{
    protected $dataTransport ;
    public function __construct(DataTransport $dataTransport){
        $this->$dataTransport = $dataTransport;
    }

	public function getAllFreightsData(){
		$freightsRecordOfLogistics=DB::table('data_transport')->select('transport_price','transport_count','transport_car_price','city','area','remarks')->where('type','=',1)->get();
		$freightsRecordOfMill=DB::table('data_transport')->select('transport_price','transport_count','city','area','address','brand','remarks')->where('type','=',2)->get();
		return $this->responseBuild(array('mill'=>$freightsRecordOfMill,'logistics'=>$freightsRecordOfLogistics));
	}


    //按地址获取运费
    //参数String(city)
    public function getFreightByCity(Request $req){
        $city = $req->city ;
        $area = $req->area ;
        if (!$area) {
            $freightInfo = DataTransport::where('city',$city)->get();   
        }else{
            $freightInfo = DataTransport::where('city',$city)->where('area',$area)->get();
        }
        $mill = $freightInfo->where('type',2)->unique('transport_price','brand')->groupBy('brand');
        foreach ($mill as $key => $value) {
            $mill[$key]=$value->max('transport_price');
        }
        
        $warehouse = $freightInfo->where('type',1)->max('transport_price');
        return $this->responseBuild(array('mill'=>$mill,'warehouse'=>$warehouse));
    }

   
	

}