<?php 
namespace App\Http\Controllers\v1;
use DB;
use App\Models\Steel_products;
use App\Models\DataModels\DataWebPrice;
use App\Models\DataModels\DataMarketDatasChild;
use Illuminate\Http\Request;
class ResourcesPageController extends BaseController{

	public function getAllProduct(){
		return Steel_products::getAllProductInfo();
	}
	public function getTimeSoltWebPrice(Request $req){
    	$time=strtotime($req->date);
    	$timeend=strtotime($req->dateEnd)+86400;
    	$data=DataWebPrice::whereBetween('file_name',[$time, $timeend])->get();

    	return $data;
    }
    public function getResourceInfo(){
        $time = strtotime(date('Y-m-d'));
        $data = [];
        for ($i=0; $i < 30; $i++) { 
            $data []= $this->getResourceInfoOneDay($time-$i*86400);
        }
        return $data;
    }
    public function getResourceInfoOneDay($time){
        return array('web' => $this->getWebPriceAvg($time), 'sopt' => $this->getSoptPriceAvg($time));;

    }
    public function getAvg($collection,$key,$discardTopPart=0,$discardBottomPart=0){
        $webprices = [];
        foreach ($collection as $index => $model) {
            $webprice = intval($model->$key);
            if ($webprice) {
                $webprices []= $webprice;
            }
        }
        return intval(array_sum($webprices)/count($webprices));
    }
    public function getWebPriceAvg($time){
        $timeend = $time+86400;
        $data = DataWebPrice::whereBetween('file_name',[$time, $timeend])->whereBetween('type',[18, 25])->get()->groupBy('brands');
        $returnData = [];
        foreach ($data as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getAvg($priceCollection,'web_price'));  
        }
        return $returnData;
    }
    public function getSoptPriceAvg($time){
        $date = date('Y-m-d',$time);
        $data = DataMarketDatasChild::where('created_at','like',$date.'%')->whereBetween('size',[18, 25])->get()->groupBy('brand');
        $returnData = [];
        foreach ($data as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getAvg($priceCollection,'price'));  
        }
        return $returnData;
    }
    public function getResourceAnalysis(Request $req){
        $data = $req->input('data');
        $discardTopPart = $data['discardTopPart'];
        $discardBottomPart = $data['discardBottomPart'];
        $brands = $data['brands'];
        $spec = $data['spec'];
        $size = $data['size'];
        $material = $data['material'];
        $timePart = $data['timePart'];
        $timePoints = $data['timePoints'];
        $timePointsInfo = array('timePoints'=>$timePoints,'spec'=>$spec,'size'=>$size,'brands'=>$brands,'discardTopPart'=>$discardTopPart,
            'discardBottomPart'=>$discardBottomPart,'material'=>$material);
        $timePartInfo = array('timePart'=>$timePart,'spec'=>$spec,'size'=>$size,'brands'=>$brands,'discardTopPart'=>$discardTopPart,
            'discardBottomPart'=>$discardBottomPart,'material'=>$material);
        $timePointsData = $this->getTimePointsData($timePointsInfo);
        $timePartData = $this->getTimePartData($timePartInfo);
        return array('timePointsData'=>$timePointsData,'timePartData'=>$timePartData);
    }
    public function getTimePointsData($data){
        $returndata = [];
        foreach ($data['timePoints'] as $key => $value) {
            $returndata[$value]['spot'] = $this->getSoptPriceAvgWithSizeAndTimePoint($value,$data['spec'],$data['size'],$data['size'],$data['material'],$data['discardTopPart'],$data['discardBottomPart']);
            $returndata[$value]['web'] = $this->getWebPriceAvgWithSizeAndTimePoint($value,$data['spec'],$data['size'],$data['size'],$data['material'],$data['discardTopPart'],$data['discardBottomPart']);
        }
        $info = [];
        foreach ($data['brands'] as $key => $value) {
            $info []=  array('brand' => $value, 'prices' => []);
            foreach ($returndata as $date => $prices) {
                $info[$key]['prices'][$date] = array('web_price'=>0,'price'=>0);
                foreach ($prices['spot'] as  $price) {
                    if ($price['brand'] == $value) {
                        $info[$key]['prices'][$date]['price'] = $price['price'];
                    }
                }
                foreach ($prices['web'] as  $price) {
                    if ($price['brand'] == $value) {
                        $info[$key]['prices'][$date]['web_price'] = $price['price'];
                    }
                }
            }
        }
        return $info;
    }
    public function getSoptPriceAvgWithSizeAndTimePoint($timePoint,$spec,$sizeBegin,$sizeEnd,$material,$discardTopPart,$discardBottomPart){
            // dd($timePoint);
        $date = $timePoint;
        $data = DataMarketDatasChild::where('created_at','like',$date.'%')
            ->where('cate_spec',$spec)->where('material',$material)
            ->whereBetween('size',[$sizeBegin, $sizeEnd])
            ->get()->groupBy('brand');
        $returnData = [];
        foreach ($data as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getAvg($priceCollection,'price',$discardTopPart,$discardBottomPart));  
        }
        return $returnData;
    }
    public function getWebPriceAvgWithSizeAndTimePoint($timePoint,$spec,$sizeBegin,$sizeEnd,$material,$discardTopPart,$discardBottomPart){
            // dd($timePoint);
        $time = strtotime($timePoint);
        $timeend = $time+86400;
        $data = DataWebPrice::whereBetween('file_name',[$time, $timeend])->whereBetween('type',[$sizeBegin, $sizeEnd])
        ->where('product',$spec)->where('material',$material)
        ->get()->groupBy('brands');
        $returnData = [];
        foreach ($data as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getAvg($priceCollection,'web_price'));  
        }
        return $returnData;
    }
    public function getTimePartData($data){
        $timePart = $data['timePart'];
        $timestart = strtotime(substr($timePart,0,10));
        $timeend = strtotime(substr($timePart,13));
        $days = ($timeend-$timestart)/86400+1;
        $returnData = [];
        for ($i=0; $i < $days; $i++) { 
            $date = date('Y-m-d',$timestart+86400*$i);
            $returndata[$date]['spot'] = $this->getSoptPriceAvgWithSizeAndTimePart($timestart+86400*$i,$data['spec'],$data['size'],$data['size'],$data['material'],$data['discardTopPart'],$data['discardBottomPart']);
            $returndata[$date]['web'] = $this->getWebPriceAvgWithSizeAndTimePart($timestart+86400*$i,$data['spec'],$data['size'],$data['size'],$data['material'],$data['discardTopPart'],$data['discardBottomPart']);
        }
        $info = [];
        // dd($returndata);
        foreach ($data['brands'] as $key => $value) {
            $info []=  array('brand' => $value, 'prices' => []);
            foreach ($returndata as $date => $prices) {
                $info[$key]['prices'][$date] = array('web_price'=>0,'price'=>0);
                foreach ($prices['spot'] as  $price) {
                    if ($price['brand'] == $value) {
                        $info[$key]['prices'][$date]['price'] = $price['price'];
                    }
                }
                foreach ($prices['web'] as  $price) {
                    if ($price['brand'] == $value) {
                        $info[$key]['prices'][$date]['web_price'] = $price['price'];
                    }
                }
            }
        }
        return $info;
    }
    public function getSoptPriceAvgWithSizeAndTimePart($timePart,$spec,$sizeBegin,$sizeEnd,$material,$discardTopPart,$discardBottomPart){
            // dd($timePart);
        $date = date('Y-m-d',$timePart);
        $data = DataMarketDatasChild::where('created_at','like',$date.'%')
            ->where('cate_spec',$spec)->where('material',$material)
            ->whereBetween('size',[$sizeBegin, $sizeEnd])
            ->get()->groupBy('brand');
        $returnData = [];
        foreach ($data as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getAvg($priceCollection,'price',$discardTopPart,$discardBottomPart));  
        }
        return $returnData;
    }
    public function getWebPriceAvgWithSizeAndTimePart($timePart,$spec,$sizeBegin,$sizeEnd,$material,$discardTopPart,$discardBottomPart){
            // dd($timePart);
        $time = $timePart;
        $timeend = $time+86400;
        $data = DataWebPrice::whereBetween('file_name',[$time, $timeend])->whereBetween('type',[$sizeBegin, $sizeEnd])
        ->where('product',$spec)->where('material',$material)
        ->get()->groupBy('brands');
        $returnData = [];
        foreach ($data as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getAvg($priceCollection,'web_price'));  
        }
        return $returnData;
    }













    public function getPriceGroupByBrand(){
        $data = $this->getResourceInfo();
        $brands = Steel_products::getAllProductInfo()['brand'];
        $returnData = [];
        foreach ($brands as $key => $brand) {
            $returnData []=array('web_price'=>[],'price'=>[],'brand'=>$brand->brand);
            foreach ($data as $datakey => $prices) {
                $returnData[$key]['price'][]=0;
                $returnData[$key]['web_price'][]=0;
                foreach ($prices['sopt'] as $pkey => $pvalue) {
                    if ($brand->brand==$pvalue['brand']) {
                        $returnData[$key]['price'][$datakey]=$pvalue['price'];
                    }
                }
                foreach ($prices['web'] as $pkey => $pvalue) {
                    if ($brand->brand==$pvalue['brand']) {
                        $returnData[$key]['web_price'][$datakey]=$pvalue['price'];
                    }
                }
            }
        }
        dd($returnData);
    }
}