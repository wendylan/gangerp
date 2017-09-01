<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
class historyDataController extends MarketDataHandleController{
	/*获得钢厂名称*/
	public function getFactorys(){
		$factoryProduct=DB::table('steel_products')->select('brand')->distinct()
			->get();
		$data=[];
		foreach ($factoryProduct as $key => $value) {
			$data[]=$value;
		}
		return $this->responseBuild( $data);
	}
	public function getProductsData(Request $Request){
		$productsData=DB::table('steel_products')->select('cate_spec as product','size as type','material')
			->where('brand','=',$Request->brand)
			->get();
		return $this->responseBuild( $productsData );

	}
	public function seachHistoryPrice(Request $Request){
		$foremostDate= intval( $Request->data['foremostDate']);
		$finalDate=intval($Request->data['finalDate']);
		$brand= $Request->data['brand'];
		$product= $Request->data['product'];
		$type= $Request->data['type'];
		$material= $Request->data['material'];
		

		/*返回数据定义*/
		$web_price=[];
		$market_price=[];

		$web_price = DB::table('data_web_price')->whereBetween('file_name', [$foremostDate, $finalDate])
		->where('product','=',$product)
		->where('type','=',$type)
		->where('material','=',$material)
		->where('brands','like','%'.$brand.'%')
		->select('file_name', 'web_price')
		->get();

		/*市场数据查询*/
		$marketPrice=DB::table('data_market_datas_child')->whereBetween('created_at', [date("Y-m-d H:i:s",$foremostDate),date("Y-m-d H:i:s", $finalDate)])
		// ->select('price','created_at','transport')
		->where('cate_spec','=',$product)
		->where('size','=',$type)
		->where('material','=',$material)
		->where('brand','=',$brand)
		->get();
		// dd($marketPrice);
		$marketPrice=$this->marketDataHandle($marketPrice);
		// dd($marketPrice);
		// $marketPrice=$marketPrice['data'];
		foreach ($marketPrice as $key => $value) {
			$market_price[]=array('price'=>$value->price,'date'=>strtotime($value->created_at),'transport'=>$value->transport);
		}
		return $this->responseBuild( array('webPrice'=>$web_price,'marketPrice'=>$market_price));
	}
}