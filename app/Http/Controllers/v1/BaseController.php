<?php

namespace App\Http\Controllers\v1;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
	use Helpers;

	public function responseBuild($data, $message='success'){
		$date = date('Y-m-d H:i:s');
		return array('data'=>$data, 'message'=>$message, 'status_code'=>200, 'date'=>$date);
	}

	public function responseMsg($msg, $status, $data){
        $responseMsg = array('message'=>$msg, 'status'=>$status, 'data'=>$data);
        return $responseMsg;
    }

    //按时间获取现货价格
	//参数 DataMarketDatasChild集合
	//返回值 DataMarketDatasChild数组
	public function getMinPrice( $data ){

		$returndata=[];
		foreach ($data as $key => $value) {
			//现货价统一↑30
			$value->price = $value->price + 30;

			$door = 1 ;

			foreach ($returndata as $rkey => $rvalue) {

				if (
					$value->brand == $rvalue->brand&&
					$value->cate_spec == $rvalue->cate_spec&&
					$value->material == $rvalue->material&&
					$value->size == $rvalue->size
				) {

					if (
						$value->price < $rvalue->price
					) {
						$returndata[$rkey] = $value;
					}

					$door = 0;
				}
			}

			if ( $door ) {

				$returndata[] = $value;

			}

		}
		return $returndata;
	}

	public function getPurchaseMinPrice($data){
		$returndata=[];
		foreach ($data as $key => $value) {

			$door = 1 ;

			foreach ($returndata as $rkey => $rvalue) {

				if (
					$value->brand == $rvalue->brand&&
					$value->cate_spec == $rvalue->cate_spec&&
					$value->material == $rvalue->material&&
					$value->size == $rvalue->size
				) {

					if (
						$value->price < $rvalue->price
					) {
						$returndata[$rkey] = $value;
					}

					$door = 0;
				}
			}

			if ( $door ) {

				$returndata[] = $value;

			}

		}
		return $returndata;
	}

	public function getEqualPriceItem($newData,$allData){
		$returnData = [];
		foreach ($newData as $key => $value) {
			foreach($allData as $akey => $avalue){
				if (
					$value->brand == $avalue->brand&&
					$value->cate_spec == $avalue->cate_spec&&
					$value->material == $avalue->material&&
					$value->size == $avalue->size&&
					$value->price == $avalue->price&&
					$value->id != $avalue->id&&
					$value->warehouse != $avalue->warehouse
				) {
					$returnData []= $avalue;
				}
			}
			$returnData []= $value;
		}
		return $returnData;
	}

	public function isBrandEqual($brand1,$brand2){
		$brands=config('source.brands_else_name');
		if($brand1==$brand2){
			return true;
		}
		foreach ($brands as $key => $value) {
			if($value['full_name']==$brand1||$value['full_name']==$brand2){
				if($value['abbreviation']==$brand1||$value['abbreviation']==$brand2){
					return true;
				}
			}
		}
		return false;
	}
}
