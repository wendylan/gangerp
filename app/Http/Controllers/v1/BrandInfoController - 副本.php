<?php
namespace App\Http\Controllers\v1;
use Illuminate\Http\Request;
use Redirect;
use App\Models\DataModels\DataBrandDetails;
// use Log;

class BrandInfoController extends BaseController{
    protected $brand_info;
    public function __construct( DataBrandDetails $brand_info ){
        $this->brand_info = $brand_info ;
    }
    // 获取所有品牌对应的供应商
    public function getAllBrandSupplier(){
        $brandInfo = $this->brand_info->getAllBrandSupplier();
        return $this->responseBuild($brandInfo);
    }
    // 获取品牌详情数据
    public function getBrandInfo(){
        $brandInfo = $this->brand_info->getBrandInfo();
        return $this->responseBuild($brandInfo);
    }
    // 添加品牌详情数据
    public function addBrandInfo(Request $req){
        $data = $req->input();
        $info = $this->brand_info->addBrandInfo($data);
        return $this->responseBuild($info,'添加成功');
    }
    // 修改品牌详情数据
    public function editBrandInfo(Request $req){
        $data = $req->input();
        $Info = $this->brand_info->editBrandInfo($data);
        return $this->responseBuild($Info,'修改成功');
    }
    // 删除品牌详情数据
    public function delBrandInfo(Request $req){
        $data = $req->input();
        $order = $this->brand_info->delBrandInfo($data);
        return $this->responseBuild($order,'删除成功');
    }

}
