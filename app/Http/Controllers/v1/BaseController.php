<?php

namespace App\Http\Controllers\v1;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
	use Helpers;

	public function responseBuild($data, $message='success'){
		return array('data'=>$data,'message'=>$message,'status_code'=>200);
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
}
