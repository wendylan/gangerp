<?php 
namespace App\Http\Controllers\v1;
use Log;
use DB;
use App\Models\Steel_products;
use App\Models\DataModels\DataWebPrice;
use App\Models\DataModels\DataMarketDatasChild;
use App\Models\DataModels\DataMarketDatas;
use Illuminate\Http\Request;
class ResourcesPageController extends BaseController{
    //规定初始化页面的数据的品名与规格
    protected $cateArray = [
        ['name'=>'螺纹钢','size'=>['18','20','22','25'],'material'=>'HRB400E'],
        ['name'=>'盘螺','size'=>['8','10'],'material'=>'HRB400E'],
        ['name'=>'高线','size'=>['8','10'],'material'=>'HPB300']
    ];
    //获取产品的品牌，规格，材质，品名
    public function getAllProduct(){
        return Steel_products::getAllProductInfo();
    }
    //按日期获取网价
    public function getTimeSoltWebPrice(Request $req){
        $time=strtotime($req->date);
        $timeend=strtotime($req->dateEnd)+86400;
        $data=DataWebPrice::whereBetween('file_name',[$time, $timeend])->get();
        return $data;
    }
    //获取资源推荐的初始化数据(30天内的螺纹钢，盘螺，高线的常用材质的数据)
    public function getResourceInfo(){
        $time = strtotime(date('Y-m-d'));
        // $webdata = DataWebPrice::whereBetween('file_name',[$time-(29*86400),$time+86400])->get();
        $webdata = DB::table('data_web_price')->whereBetween('file_name',[$time-(29*86400),$time+86400])->get();
        $spotdata = DB::table('data_market_datas_child')->whereBetween('created_at',[date("Y-m-d H:i:s",$time-(29*86400)),date("Y-m-d H:i:s",($time+86400))])->get();

        $web = $this->getWebCateSpecData('type','螺纹钢',$webdata);
        $spot = $this->getCateSpecData('size','螺纹钢',$spotdata);
        $diskWeb = $this->getWebCateSpecData('type','盘螺',$webdata);
        $diskSpot = $this->getCateSpecData('size','盘螺',$spotdata);
        $highSpeedWireWeb = $this->getWebCateSpecData('type','高线',$webdata);
        $highSpeedWirespot = $this->getCateSpecData('size','高线',$spotdata);

        $webdata = ['web'=>$web,'diskWeb'=>$diskWeb,'highSpeedWireWeb'=>$highSpeedWireWeb];
        $spotdata = ['spot'=>$spot,'diskSpot'=>$diskSpot,'highSpeedWirespot'=>$highSpeedWirespot];
        $data = [];
        for ($i = 0; $i < 30; $i++) { 
            $data []= $this->getResourceInfoOneDay($time-$i*86400,$spotdata,$webdata);
        }
        return array('data'=>$data,'date'=>date('Y-m-d'));
        // $webdata = $webdata->toArray();
        // $spotdata = $spotdata->toArray();
        // return array('data'=>['webdata'=>$webdata,'spotdata'=>$spotdata],'date'=>date('Y-m-d'));
    }
    //获取一天的盘螺数据
    public function getResourceInfoOneDay($time,$spotdata,$webdata){
        $web = $this->getWebPriceAvg($time,$webdata['web']);
        $spot = $this->getSoptPriceAvg($time,$spotdata['spot']);
        $diskWeb = $this->getWebPriceAvg($time,$webdata['diskWeb']);
        $diskSpot = $this->getSoptPriceAvg($time,$spotdata['diskSpot']);
        // dd($diskSpot);
        $highSpeedWireWeb = $this->getWebPriceAvg($time,$webdata['highSpeedWireWeb']);   
        $highSpeedWirespot = $this->getSoptPriceAvg($time,$spotdata['highSpeedWirespot']);
        $date = date("Y-m-d",$time);
        $data = $this->structureHandle($web,$spot,$date);
        $disk = $this->structureHandle($diskWeb,$diskSpot,$date);
        $highSpeedWire = $this->structureHandle($highSpeedWireWeb,$highSpeedWirespot,$date);
        return array('disk' => $disk, 'highSpeedWire' => $highSpeedWire, 'data'=>$data, 'date'=>$date,'web'=>$web,'sopt'=>$spot);
    }
    //封装数据
    public function structureHandle($web,$spot,$date){
        $data = ['date'=>$date,'data'=>[]];
        // dd($spot);
        $newspot = [];
        foreach ($spot as $key => $value) {
            $door = 1;
            foreach ($newspot as $nskey => $nsvalue) {
                if($nsvalue['brand'] == $value['brand']){
                    $newspot[$nskey]['price'][]=["price" => $value['price'],"trans" => $value['trans']];
                    $door = 0;
                    break;
                }
            }
            if($door){
                $newspot[]=
                [
                 'brand'=>$value['brand'],
                 'price'=>[
                   ["price" => $value['price'],"trans" => $value['trans']]
                 ]
                ];
            }
        }
        foreach ($newspot as $skey => $svalue) {
            foreach ($web as $wkey => $wvalue) {
                if($this->isBrandEqual($svalue['brand'],$wvalue['brand'])){
                    $price_diff = 0;
                    if($wvalue['price']&&count($svalue['price'])){
                        $spotprice = 0;
                        if(count($svalue['price'])>0){
                            //有仓提先选仓提。。。ps:仓提现货价永远在直送前面
                            $spotprice = $svalue['price'][0]['price'];
                            $trans = $svalue['price'][0]['trans'];
                        }
                        $price_diff = $wvalue['price'] - $spotprice;
                    }
                    $data['data'][] = array(
                        'brand'=>$svalue['brand'],
                        'web'=>$wvalue['price'],
                        'web_float'=>$wvalue['float'],
                        'allspot'=>$svalue['price'],
                        'price_diff'=>$price_diff,
                        'trans'=>$trans,
                        'spot'=>$spotprice
                    );
                }
            }
        }
        return $data;
    }
    //获取网价均价
    public function getWebPriceAvg($time,$data){
        $timeend = $time+86400;
        $times = DB::table('data_web_price_date')->whereBetween('date',[$time,$timeend])->get();
        $file_name = "0-0-0";
        if($times->count()){
            $file_name = $times[$times->count()-1]->date;
        }
        $data = $data->where('file_name','=',$file_name);
        $data = $data->groupBy('brands');
        $returnData = [];
        foreach ($data as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getPrice($priceCollection,'web_price'),'float'=>$this->getPrice($priceCollection,'price_change'));  
        }
        return $returnData;
    }
    //获取现货价均价
    public function getSoptPriceAvg($time,$data){
        $date = date('Y-m-d',$time);
        $parent = DataMarketDatas::getParentIdByDate($date);
        $parent_id = [];
        //获取最新报价的parent_id
        if($parent->count()){
            $parent_id []= $parent[$parent->count()-1];
        }
        $data = $this->getDetailData($parent_id,$data);

        $warehouse = $data['warehouse']->groupBy('brand');
        $mill = $data['mill']->groupBy('brand');
        $returnData = [];

        foreach ($warehouse as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getPrice($priceCollection,'price'),'trans'=>'仓');  
        }

        foreach ($mill as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getPrice($priceCollection,'price'),'trans'=>'直');  
        }
        // dd($returnData);
        return $returnData;
    }
    //区分仓提跟直送
    public function getDetailData($parent,$data){
        $mill = [];
        $warehouse = [];
        foreach ($parent as $key => $value) {
            foreach ($data['mill'] as $dataKey => $dataValue) {
                if($dataValue->parent_id == $value->id){
                    $mill[]=$dataValue;
                }
            }
            foreach ($data['warehouse'] as $dataKey => $dataValue) {
                if($dataValue->parent_id == $value->id){
                    $warehouse[]=$dataValue;
                }
            }
        }
        $returndata = ['warehouse'=>collect($warehouse),'mill'=>collect($mill)];
        return $returndata;
    }
    //资源推荐搜索更多数据
    public function getResourceAnalysis(Request $req){
        $data = $req->input('data');
        $discardTopPart = $data['discardTopPart'];
        $discardBottomPart = $data['discardBottomPart'];
        $brands = $data['brands'];
        $spec = $data['spec'];
        $size = $this->sizeAnalysis($data['size']);
        $material = $data['material'];
        $timePointsData = [];
        $timePartData = [];
        if(array_key_exists('timePoints',$data)){
            $timePoints = $data['timePoints'];
            $timePointsInfo = array('timePoints'=>$timePoints,'spec'=>$spec,'size'=>$size,'brands'=>$brands,'discardTopPart'=>$discardTopPart,
                'discardBottomPart'=>$discardBottomPart,'material'=>$material);
            $timePointsData = $this->getTimePointsData($timePointsInfo);
        }

        if (array_key_exists('timePart',$data)) {
            if($data['timePart']){
                $timePart = $data['timePart'];
                $timePartInfo = array('timePart'=>$timePart,'spec'=>$spec,'size'=>$size,'brands'=>$brands,'discardTopPart'=>$discardTopPart,
                    'discardBottomPart'=>$discardBottomPart,'material'=>$material);
                $timePartData = $this->getTimePartData($timePartInfo);
            }
        }   
        return array('timePointsData'=>$timePointsData,'timePartData'=>$timePartData);
    }
    //区间段规格区分
    public function sizeAnalysis($size){
        $at = stripos($size,' - ');
        $sizes = [];
        if($at){
            $sizes = explode(' - ',$size);
        }else{
            $sizes[] = $size; 
            $sizes[] = $size;                                                                           
        }
        for ($i=0; $i <count($sizes) ; $i++) { 
            $sizes[$i] = intval($sizes[$i]);
        }
        // dd($sizes);
        return $sizes;
    }
    //获取时间点数据
    public function getTimePointsData($data){
        $returndata = [];
        foreach ($data['timePoints'] as $key => $value) {
            //获取时间点的网价数据
            $returndata[$value]['spot'] = 
            $this->getSoptPriceAvgWithSizeOneDay(strtotime($value),$data['spec'],$data['size'][0],$data['size'][1],$data['material']);
            //获取时间点的现货数据
            $returndata[$value]['web'] = 
            $this->getWebPriceAvgWithSizeOneDay(strtotime($value),$data['spec'],$data['size'][0],$data['size'][1],$data['material']);
        }
        $info = [];
        foreach ($data['brands'] as $key => $value) {
            $info []=  array('brand' => $value, 'prices' => []);
            foreach ($returndata as $date => $prices) {
                $info[$key]['prices'][$date] = array('web_price'=>0,'price'=>0,'method'=>'');
                foreach ($prices['spot'] as  $price) {
                    if ($price['brand'] == $value) {
                        $info[$key]['prices'][$date]['price'] = $price['price'];
                        $info[$key]['prices'][$date]['method'] = $price['method'];
                    }
                }
                foreach ($prices['web'] as  $price) {
                    if ($this->isBrandEqual($price['brand'] , $value)) {
                        $info[$key]['prices'][$date]['web_price'] = $price['price'];
                    }
                }
            }
        }
        return $info;
    } 
   
    //获取时间段数据
    public function getTimePartData($data){
        $timePart = $data['timePart'];
        $timestart = strtotime(substr($timePart,0,10));
        $timeend = strtotime(substr($timePart,13));
        $days = ($timeend-$timestart)/86400+1;
        $returndata = [];
        for ($i=0; $i < $days; $i++) { 
            $date = date('Y-m-d',$timestart+86400*$i);
            $returndata[$date]['spot'] = 
            $this->getSoptPriceAvgWithSizeOneDay($timestart+86400*$i,$data['spec'],$data['size'][0],$data['size'][1],$data['material']);
            $returndata[$date]['web'] = 
            $this->getWebPriceAvgWithSizeOneDay($timestart+86400*$i,$data['spec'],$data['size'][0],$data['size'][1],$data['material']);
        }
        $info = [];
        foreach ($data['brands'] as $key => $value) {
            $info []=  array('brand' => $value, 'prices' => []);
            foreach ($returndata as $date => $prices) {
                $info[$key]['prices'][$date] = array('web_price'=>0,'price'=>0,'method'=>'');
                foreach ($prices['spot'] as  $price) {
                    if ($this->isBrandEqual($price['brand'] , $value)) {
                        $info[$key]['prices'][$date]['price'] = $price['price'];
                        $info[$key]['prices'][$date]['method'] = $price['method'];
                    }
                }
                foreach ($prices['web'] as  $price) {
                    if ($this->isBrandEqual($price['brand'] , $value)) {
                        $info[$key]['prices'][$date]['web_price'] = $price['price'];
                    }
                }
            }
        }
        return $info;
    }
    //获取一天的现货数据
    public function getSoptPriceAvgWithSizeOneDay($timePart,$spec,$sizeBegin,$sizeEnd,$material){
        // dd($timePart);
        $date = date('Y-m-d',$timePart);
        $data = $this->getSpotDataDate($date, $spec, $material, $sizeBegin, $sizeEnd);
        $mill = collect([]);
        $warehouse = collect([]);
        // 获取最新数据区分直送与自提(有仓提选仓提)
        if($data['warehouse']->count()){
            $warehouse = $data['warehouse'];
        }
        if($data['mill']->count()){
            $mill = $data['mill'];
        }
        $returnData = [];

       
        $mill=$mill->groupBy('brand');
        foreach ($mill as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getPrice($priceCollection,'price'),'method'=>'mill');  
        }

        $warehouse=$warehouse->groupBy('brand');
        foreach ($warehouse as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getPrice($priceCollection,'price'),'method'=>'warehouse');  
        }
        return $returnData;
    }
    //向数据库查询当天现货的数据
    public function getSpotDataDate($date, $spec, $material, $sizeBegin, $sizeEnd){
        $data = DB::table('data_market_datas_child')->where('created_at','like',$date.'%')
            ->where('cate_spec',$spec)->where('material',$material)
            ->whereBetween('size',[$sizeBegin, $sizeEnd])
            ->get();
        //
        $parent = DataMarketDatas::getParentIdByDate($date);
        $parent_id = [];
        //获取最新报价的parent_id
        if($parent->count()){
            $parent_id []= $parent[$parent->count()-1];
        }
         $data = $this->getNewsData($parent_id,$data);
        return $data;
    }

    //获取最新数据区分直送与自提
    public function getNewsData($parent_id,$data){
        $mill = [];
        $warehouse = [];
        foreach ($parent_id as $key => $value) {
            foreach ($data as $dataKey => $dataValue) {
                if($dataValue->parent_id == $value->id){

                    if($dataValue->transport=='直送'){
                        $mill[]=$dataValue;
                    }
                    
                    else{
                        $warehouse[]=$dataValue;
                    }
                }
            }
        }
        $returndata = ['warehouse'=>collect($warehouse),'mill'=>collect($mill)];
        return $returndata;
    }
    //获取一天的网价数据
    public function getWebPriceAvgWithSizeOneDay($timePart,$spec,$sizeBegin,$sizeEnd,$material){
        //获取当天数据
        $time = $timePart;
        $timeend = $time+86400;
        $data = DataWebPrice::whereBetween('file_name',[$time, $timeend])->whereBetween('type',[$sizeBegin, $sizeEnd])
        ->where('product',$spec)->where('material',$material)
        ->get();
        //获取最新地网价数据
        $times = DB::table('data_web_price_date')->whereBetween('date',[$time,$timeend])->get();
        $file_name = "undifined";
        if($times->count()){
            $file_name = $times[$times->count()-1]->date;
        }
        $data = $data->where('file_name','<',$timeend);
        $data = $data->where('file_name','>',$time);
        $data = $data->groupBy('brands');

        $returnData = [];
        foreach ($data as $brand => $priceCollection) {
            $returnData[]=array('brand'=>$brand,'price'=>$this->getPrice($priceCollection,'web_price'));  
        }
        return $returnData;
    }

    //异常数据剔除功能实现
    public function spliceExceptionData($data,$top=0,$bottom=0){
        if($top<0){
            $this->response->error('上限不能小于0',500);
        }
        if($bottom<0){
            $this->response->error('下限不能小于0',500);   
        }
        if(($top+$bottom)>100){
            $this->response->error('数据量不能大于100%',500);
        }
    }
    //获取规格范围内数据
    public function getCateSpecData($key,$spec,$data){
        $warehouse = [];
        $mill = [];
        $cateArray = $this->cateArray;
        // dd($data[0]);
        foreach ($data as $dkey => $value) {
            if($spec==$value->cate_spec){
                if($value->transport=='直送'){
                    foreach ($cateArray as $ckey => $cvalue) {
                        if($cvalue['name']==$spec && $cvalue['material']==$value->material){
                            foreach ($cvalue['size'] as $skey => $svalue) {
                                if($value->$key==$svalue){
                                    $mill[]=$value;
                                    break;
                                }
                            }
                        }
                    }
                }else{
                    foreach ($cateArray as $ckey => $cvalue) {
                        if($cvalue['name']==$spec && $cvalue['material']==$value->material){
                            foreach ($cvalue['size'] as $skey => $svalue) {
                                if($value->$key==$svalue){
                                    $warehouse[]=$value;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
        $warehouse = collect($warehouse);
        $mill = collect($mill);
        return ['warehouse'=>$warehouse,'mill'=>$mill];
    }
    //获取网价规格内数据
    public function getWebCateSpecData($key,$spec,$data){
        $returndata = [];
        $cateArray = $this->cateArray;
        foreach ($data as $dkey => $value) {
            if($value->product == $spec){
                foreach ($cateArray as $ckey => $cvalue) {
                    if($cvalue['name']==$spec && $cvalue['material']==$value->material){
                        foreach ($cvalue['size'] as $skey => $svalue) {
                            if($value->$key==$svalue){
                                $returndata[]=$value;
                                break;
                            }
                        }
                    }
                }
            }
        }
        return  collect($returndata);
    }
    //求平均价格
    public function getAvg($collection,$key){
        $prices = [];
        foreach ($collection as $index => $model) {
            $price = intval($model->$key);
            if ($price) {
                $prices []= $price;
            }
        }
        $count = count($prices);
        if(!$count){
            return 0;
        }
        return intval(array_sum($webprices)/$count);
    }
    //求价格众数
    public function getPrice($collection, $key){
        $prices = [];
        $price = ['count'=>0,'price'=>0];
        foreach ($collection as $index => $model) {
            $door = 1;
            foreach ($prices as $pricesKey => $pricesValue) {
                if($pricesValue['price']==$model->$key){
                    $prices[$pricesKey]['count'] += 1;
                    $door = 0;
                    break;
                }
            }
            if($door){
               $prices []= ['price'=>$model->$key,'count'=>1]; 
            }
        }

        foreach ($prices as $key => $value) {
            if( $key==0||$value['count']>$price['count']){
                $price = $value;
            }
        }
        return $price['price'];
    }
}