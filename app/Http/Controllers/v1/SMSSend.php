<?php
namespace App\Http\Controllers\v1;
use Illuminate\Http\Request;
use App\Http\SMS\SmsSingleSender;

trait SMSSend {
	public function testSendSMS($phoneNumber,$param){
		$appid = 1400049889;
	    $appkey = "1feec1b158d0a4612a298b2051a13f21";
	    $singleSender = new SmsSingleSender($appid, $appkey);
	    $result = $singleSender->sendWithParam("86", $phoneNumber,56444,[$param],'66钢铁');
	    return $result;
	}
}