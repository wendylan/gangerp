<?php

namespace App\Http\Controllers\v1;

use DB;
use App\Models\DataModels\DataMarketDatas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class sqlController extends Controller
{
    //
    public function setMarketPriceRule(){
    	$steel_products = DB::table('steel_products')->get();
    	$result = [];
    	foreach ($steel_products as $key => $value) {
    		$result[] = ['steel_products_id'=>$value->id, 'float_type'=>1, 'float_price'=>10];
    	}
    	DB::table('data_market_price_rule')->insert($result);
    }

    public function setMarketRule(){
    	$steel = DB::table('steel_factorys')->get();
    	$datas = [];
    	foreach ($steel as $key => $value) {
    		$datas[] = ['brand_id'=>$value->id, 'active_rule'=>1];
    	}
    	DB::table('data_market_rule')->insert($datas);
    }

    public function tempTest(){
    	DataMarketDatas::createMarketReport();
    }
}
