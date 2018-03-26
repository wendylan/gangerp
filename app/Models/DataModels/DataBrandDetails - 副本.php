<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;
use Log;

class DataBrandDetails extends Model
{

    protected $table = 'data_brand_details';
    protected $guarded = [];

    //产生唯一字符串
    public function getUniName(){
        return md5(uniqid(microtime(true),true));
    }
    // 获取后缀名
    public function getExt($name){
        return substr($name['name'], strrpos($name['name'],'.'));
    }
    // 处理上传数据
    public function handleData(){
        $brands = isset($_POST['brands'])? $_POST['brands'] : '';
        $context = isset($_POST['context'])? $_POST['context'] : '';
        $cate_spec = isset($_POST['cate_spec'])? $_POST['cate_spec'] : '';
        $transport_way = isset($_POST['transport_way'])? $_POST['transport_way'] : '';
        $supplier = isset($_POST['supplier'])? $_POST['supplier'] : [];
        $supplierData = [];
        foreach ($supplier as $key => $value) {
            $supplierData[] = ['name' => $value];
        }
        $reviewInfo = array(
            'brands'=>$brands,
        	'context'=>$context,
        	'cate_spec'=>$cate_spec,
        	'transport_way'=>$transport_way,
        	'supplier'=>$supplierData
        );
        return $reviewInfo;

    }
    // 保存图片返回路径字符串
    public function handleImg($name){
        $filename = $this->getUniName().$this->getExt($_FILES[$name]);
        $destinationPath = public_path('images/').$filename;
        $file = "..\..\public\images\\".$filename;

        if(move_uploaded_file($_FILES[$name]['tmp_name'], $destinationPath )){
            return $file;
        }
    }
    // 检查是否有相对应的上传图片
    public function checkFill($name){
        if($_FILES[$name]['tmp_name']){
            return true;
        }
        return false;
    }
    // 获取所有品牌对应的供应商
    public function getAllBrandSupplier(){
        $result = $this->get();
        $returnData = [];
        if(count($result)){
            foreach ($result as $key => $value) {
                $returnData['brands'] = $value['brands'];
                $returnData['supplier'] = json_decode($value['supplier']);
            }
        }
        return $returnData;
    }
    // 获取品牌详情信息
    public function getBrandInfo(){
    	$result = [];
    	$data = $this->get();
        if(count($data)){
            foreach ($data as $key => $value) {
                $value['steel_certificate'] = json_decode($value['steel_certificate']);
                $value['supplier'] = json_decode($value['supplier']);
                $result[] = $value;
            }
        }
        return $result;
    }

    // 添加品牌详情信息
    public function addBrandInfo($data){
        $temp = [
            [ 'type' => 'first','value' => $this->handleImg('first') ],
            [ 'type' => 'second','value' => $this->handleImg('second') ],
            [ 'type' => 'third','value' => $this->handleImg('third') ]
        ];
        $review = $this->handleData();
        $result = DataBrandDetails::create(array(
        	'brands'=>$review['brands'],
        	'context'=>$review['context'],
        	'cate_spec'=>$review['cate_spec'],
        	'cate_style'=>($this->handleImg('cate_style')),
        	'weight_standard'=>($this->handleImg('weight_standard')),
        	'transport_way'=>$review['transport_way'],
        	'steel_certificate'=>json_encode($temp),
        	'quality_certificate'=>($this->handleImg('quality_certificate')),
        	'supplier'=>json_encode($review['supplier'])
        ));
        return $this->getBrandInfo();
    }

    // 修改品牌详情信息
    public function editBrandInfo($data){
        $info = DB::table('data_brand_details')->where('id', $data['id'])->get();
        $temp = [
            [ 'type' => 'first','value' => $this->checkFill('first') ? $this->handleImg('first') : json_decode($info[0]->steel_certificate)[0]->value ],
            [ 'type' => 'second','value' => $this->checkFill('second') ? $this->handleImg('second') : json_decode($info[0]->steel_certificate)[1]->value  ],
            [ 'type' => 'third','value' => $this->checkFill('third') ? $this->handleImg('third') : json_decode($info[0]->steel_certificate)[2]->value ]
        ];
        $review = $this->handleData();
        $reviewInfo = array(
        	'brands'=>$review['brands'],
        	'context'=>$review['context'],
        	'cate_spec'=>$review['cate_spec'],
        	'cate_style'=>($this->checkFill('cate_style') ? $this->handleImg('cate_style') : $info[0]->cate_style),
        	'weight_standard'=>($this->checkFill('weight_standard') ? $this->handleImg('weight_standard') : $info[0]->weight_standard),
        	'transport_way'=>$review['transport_way'],
        	'steel_certificate'=>json_encode($temp),
        	'quality_certificate'=>($this->checkFill('quality_certificate') ? $this->handleImg('quality_certificate') : $info[0]->quality_certificate ),
        	'supplier'=>json_encode($review['supplier'])
        );
        DB::table('data_brand_details')->where('id', $data['id'])->update($reviewInfo);
        return $this->getBrandInfo();
    }

    // 删除品牌详情信息
    public function delBrandInfo($data){
        $info = $this::find($data['id']);
        Storage::delete($info->cate_style);
        Storage::delete($info->weight_standard);
        Storage::delete($info->quality_certificate);
        $tmp = json_decode($info['steel_certificate']);
        foreach ($tmp as $key => $value) {
            Storage::delete($value->value);
        }
        $info = $info->delete();
        return $info;
    }
}

 ?>
