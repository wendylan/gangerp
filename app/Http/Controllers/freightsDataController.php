<?php
namespace App\Http\Controllers;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Notifications\NotificationTest;
class freightsDataController extends Controller{
	public function getAllFreightsData(){
		$freightsRecordOfLogistics=DB::table('data_transport')->select('transport_price','transport_count','transport_car_price','city','area','remarks')->where('type','=',1)->get();
		$freightsRecordOfMill=DB::table('data_transport')->select('transport_price','transport_count','city','area','address','brand','remarks')->where('type','=',2)->get();
		return array('mill'=>$freightsRecordOfMill,'logistics'=>$freightsRecordOfLogistics);
	}

}