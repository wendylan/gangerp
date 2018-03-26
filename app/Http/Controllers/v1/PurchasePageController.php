<?php 
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\Steel_products;
class PurchasePageController extends BaseController{
	//按品牌获取钢材规格
	//params(String $req->brand) eg:'广钢'
	//返回值 array;
	public function getBrandSpec(Request $req){
		$brand=$req->brand;
		$data=Steel_products::getBrandSteelSpecs($brand);
		return $this->responseBuild($data);
	}

	public function getBrandGroupSpec(Request $req){
		if(!$req->brand||!count($req->brand)){
			return $this->responseBuild([]);
		}
		$data=Steel_products::getBrandGroupSpec($req->brand);
		return $this->responseBuild($data);
	}

}

?>