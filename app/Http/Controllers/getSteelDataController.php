<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Auth;

class GetSteelDataController extends Controller{
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
			return/*null时返回值*/'';
		}else {
			return $this->responseMsg($msg='null', $status='success', $data=array(
			"webPriceDataRecord"=>$webPriceDataRecord,
			));
		}
	}
	/*分页查寻网价日期*/
	public function getWebPriceDate(){
		$marketDatas = DB::table('data_web_price_date')->orderBy('date', 'desc')->paginate(3);
		return $this->responseMsg($msg='null', $status='success', $data=$marketDatas);
	}
	/*查看网价数据*/
	public function checkWebPriceData(Request $Request){
		$recent=$Request->data;
		$webPriceDataRecord=DB::table('data_web_price')->select('product','type','material','brands','web_price','price_change')
		->where('file_name','=',$recent)->get();
		//对于没有找到的记录到“public”目录下的“mysteelData”文件夹中找
		if($webPriceDataRecord->isEmpty()){
			return;			
		}else {
			return $this->responseMsg($msg='null', $status='success', $data=array(
				"webPriceDataRecord"=>$webPriceDataRecord,
			));
		}
	
	}
	/*查看网价页面更新操作*/
	public function updateWebPriceData(Request $Request){
      	$newRecord=$Request->newRecord;
      	if($newRecord==""){
      		return $this->responseMsg("null","warning","检测不到数据更新");
      	}else{
	      	foreach ($newRecord as $key => $value) {
	      		DB::table('data_web_price')
	            ->where('id',$value['id'])
	            ->update(['web_price' => $value['web_price']]);
	      	}
	  		return $this->responseMsg("null","success","更新成功");
      	}
    }
    /*新增网价页面保存2次调价*/
    public function saveWebPriceData(Request $Request){
      	$newRecord=$Request->newRecord;
      	if($newRecord==""){
      		return $this->responseMsg("null","warning","检测不到数据更新");
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
  		return $this->responseMsg("null","success","保存成功!");
    }

	public function responseMsg($msg, $status, $data){
        $responseMsg = array('message'=>$msg, 'status'=>$status, 'data'=>$data);
        return $responseMsg;
    }

    public function getSteelInfo(){
    	return DB::table('steel_products')->select("brand","cate_spec","size","material")->get();
    }

    public function getSteelBrandSource(Request $Request){
    	$date=$Request->input('date');
    	$data=DB::table('data_market_datas_child')->select('brand','price_source')->where('created_at', 'like', $date.'%')->distinct()->get();
    	$parent_id=DB::table('data_market_datas_child')->where('created_at', 'like', $date.'%')->max('parent_id');
    	return array('data'=>$data,'parent_id'=>$parent_id);
    }

}