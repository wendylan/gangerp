<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use Auth;
use App\Models\DataModels\DataWebPrice;
use App\Models\DataModels\DataWebPriceDate;
class GetSteelDataController extends BaseController{
	protected $dataWebPrice;
	public function __construct(DataWebPrice $dataWebPrice){
		$this->dataWebPrice = $dataWebPrice;
	}
/*去重测试，可删除，前端无调用*/
/*	public function getSteelData1(){
		// sql去重查询，test
		$testCutRedundant=DB::table('data_web_price')->select('product')->distinct()->get();
		dd($testCutRedundant);
	}*/
	/*新增网价页面获取数据*/
	public function initForGetWebPrice(){
		$recent=DB::table('data_web_price_date')->orderBy('date', 'desc')->first();
		$webPriceDataRecord=DB::table('data_web_price')->select('product','type','material','brands','web_price','price_change')
		->where('file_name','=',$recent->date)->get();
		if($webPriceDataRecord->isEmpty()){
			$this->response->error('当日无数据',500);
		}else {
			return $this->responseBuild(array("webPriceDataRecord"=>$webPriceDataRecord));
		}
	}
	/*分页查寻网价日期*/
	public function getWebPriceDate(){
		$marketDatas = DB::table('data_web_price_date')->where('date','<>',null)->orderBy('date', 'desc')->paginate(3);
		return $this->responseBuild( $marketDatas );
	}
	/*查看网价数据*/
	public function checkWebPriceData(Request $Request){
		$recent=$Request->data;
		$webPriceDataRecord=DB::table('data_web_price')->select('id','product','type','material','brands','web_price','price_change')
		->where('file_name','=',$recent)->get();
		if($webPriceDataRecord->isEmpty()){
			$this->response->error('当日无数据',500);		
		}else {
			return $this->responseBuild($webPriceDataRecord);
		}
	}
	/*查看网价页面更新操作*/
	public function updateWebPriceData(Request $Request){
      	$newRecord=$Request->newRecord;
      	if($newRecord==""){
      		$this->response->error('检测不到数据更新',500);
      	}else{
	      	foreach ($newRecord as $key => $value) {
	      		DB::table('data_web_price')
	            ->where('id',$value['id'])
	            ->update(['web_price' => $value['web_price']]);
	      	}
	  		return $this->responseBuild( null,"更新成功" );
      	}
    }
    /*新增网价页面保存2次调价*/
    public function saveWebPriceData(Request $Request){
      	$newRecord=$Request->newRecord;
      	if($newRecord==""){
      		$this->response->error('检测不到数据更新',500);
      	}

      	$toInsert=[];
      	$fileName=time();
      	foreach ($newRecord as $key => $value){
      		$value['file_name']=$fileName;
      		$value['id']='';
      		$toInsert[]=$value;
      	}
      	DB::table('data_web_price')->insert($toInsert);
  		DB::table('data_web_price_date')->insert(['date'=>$value['file_name'],'id'=>'']);
  		return $this->responseBuild( null,"保存成功!" );
    }


    public function getSteelInfo(){
    	return $this->responseBuild( DB::table('steel_products')->select("brand","cate_spec","size","material")->get());
    }

    public function getSteelBrandSource(Request $Request){
    	$date=$Request->input('date');
    	$data=DB::table('data_market_datas_child')
    	->select('brand','price_source')->where('created_at', 'like', $date.'%')->distinct()->get();
    	$parent_id=DB::table('data_market_datas_child')->where('created_at', 'like', $date.'%')->max('parent_id');
    	return $this->responseBuild( array('data'=>$data,'parent_id'=>$parent_id ));
    }
    //按日期获取网价
    //参数 $req-date String('1993-07-01');
    public function getWebPriceByDate(Request $req){
    	$time=strtotime($req->date);
    	$timeend=$time+86400;
    	$date=DataWebPriceDate::whereBetween('date', [$time, $timeend])->get();
    	$date=$date->max('date');
    	$data=DataWebPrice::where('file_name',$date)->get();
    	return $data;
    }
}