<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\DataModels\DataUserCarInfo;

use Auth;
class UserCarInfoController extends BaseController{
    protected $car_info;
    public function __construct( DataUserCarInfo $car_info ){
        $this->car_info = $car_info ;
    }
    // 获取物流司机数据
    public function getCarInfo(){
        $userCarInfo = $this->car_info->getCardInfo();
        // return $userCarInfo ;
        return $this->responseBuild($userCarInfo); 
    }
    // 添加物流司机数据
    public function addCarInfo(Request $req){
        $carInfo = $req->input();
        $info = $this->car_info->addCarInfo($carInfo);
        return $this->responseBuild($info);
    }
    // 修改司机物流数据
    public function editCarInfo(Request $req){
        $carInfo = $req->input();
        $Info = $this->car_info->editCardInfo($carInfo);
        return $this->responseBuild( $Info, 'success');
    }
    // 删除司机物流数据
    public function deleteCarInfo(Request $req){
        $data = $req->input();
        $order = $this->car_info->deleteCarInfo($data);
        return $this->responseBuild('删除成功');
    }

}
