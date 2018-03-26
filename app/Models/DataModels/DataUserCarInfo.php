<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class DataUserCarInfo extends Model
{
    protected $table = 'data_user_car_info';
    protected $guarded = [];
    public function saveInfo($data)
	{
		$user_id = Auth::user()->id;
		if($data['car_info_change']){
			foreach ($data['logistics_info'] as $key => $value) {
				$info = $this->getCarInfoByUserIdAndPlateNumber($user_id,$value['plate_number']);
				if(!$info->count()){
					$this->createCarInfo($value);
				}
				else{
					$this->updateCardInfo($value,$info[0]);
				}
			}
		}
	}
	public function getCarInfoByUserIdAndPlateNumber($id,$number){
		return $this::where('plate_number',$number)->where('user_id',$id)->get();
	}
    public function createCarInfo($data){
    	DataUserCarInfo::create(array(
			'plate_number'=>$data['plate_number'],
			'driver'=>$data['driver'],
			'driver_tel'=>$data['driver_tel'],
			'driver_idcard_num'=>$data['driver_idcard_num'],
			'user_id'=>Auth::user()->id,
		));
    }
    public function updateCardInfo($data,$info){
    	$info->driver = $data['driver'];
    	$info->driver_tel = $data['driver_tel'];
    	$info->driver_idcard_num = $data['driver_idcard_num'];
    	$info->save();
    }

    // 添加车信息
    public function addCarInfo($data){
    	DataUserCarInfo::create(array(
			'car_source'=>$data['car_source'],
			'plate_number'=>$data['plate_number'],
			'driver'=>$data['driver'],
			'driver_tel'=>$data['driver_tel'],
			'driver_idcard_num'=>$data['driver_idcard_num'],
			'user_id'=>Auth::user()->id,
			'remarks'=>$data['remarks']
		));
		return $this->getCardInfo();
    }

    // 获取物流司机数据
    public function getCardInfo(){
    	return $this::where('user_id',Auth::user()->id)->get();
    }
    // 修改司机物流信息
    public function editCardInfo($data){
    	$info = $this::find($data['id']);
    	$info->driver = $data['driver'];
    	$info->plate_number = $data['plate_number'];
    	$info->driver_tel = $data['driver_tel'];
    	$info->driver_idcard_num = $data['driver_idcard_num'];
    	$info->car_source = $data['car_source'];
    	$info->remarks = $data['remarks'];
    	$info->save();
    	return $info;
    }
    // 删除车信息
    public function deleteCarInfo($data){
        $order = $this::find($data['id']);
        $order = $order->delete();
        return $order;
    }
}


 ?>
