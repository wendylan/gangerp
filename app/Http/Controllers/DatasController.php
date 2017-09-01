<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Auth;
use Redirect;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\GetSteelDataController;

use App\Models\DataModels\DataPriceSource;
use App\Models\DataModels\DataWarehouse;
use App\Models\DataModels\DataMarketDatas;
use App\Models\DataModels\DataMarketDatasChild;
use App\Models\DataModels\DataTransport;

class DatasController extends Controller
{
    // Get token
    public function getToken(){
        return csrf_token();
    }

    // 获取规格数据
    public function allspecs(Request $Request){
        if(is_string($Request->data)){
            $specs = DB::table('steel_products')->where('brand', $Request->data)->get();
            $result=array();
            $_result=array();

            // 品名和材质去重
            foreach ($specs as $key => $value) {
                $result[$value->cate_spec][$value->material][]=$value->size;
            }

            // 组合成树形结构数据
            $count = 0;
            foreach ($result as $name => $value) {
                $_result[] = array('name'=>$name);
                foreach ($result[$name] as $material => $_value) {
                    $_result[$count]['material'][] = array('name'=>$material);
                    $arrLength = count($_result[$count]['material']) - 1;
                    // Size去重
                    $result[$name][$material] = array_unique($result[$name][$material]);

                    foreach ($result[$name][$material] as $index => $size) {
                        if($_result[$count]['material'][$arrLength]['name'] == $material){
                            $_result[$count]['material'][$arrLength]['size'][] = array('name'=>$size);
                        }
                    }
                }
                $count += 1;
            }
            return $_result;

        }else{
            return 'Error';
        }
    }

    // 获取规格数据
    public function getAllspecsAndNotice(Request $Request){
        if(is_string($Request->data)){
            $specs = DB::table('steel_products')->where('brand', $Request->data)->get();
            $result=array();
            $_result=array();

            // 品名和材质去重
            foreach ($specs as $key => $value) {
                $result[$value->cate_spec][$value->material][]=$value->size;
            }

            // 组合成树形结构数据
            $count = 0;
            foreach ($result as $name => $value) {
                $_result[] = array('name'=>$name);
                foreach ($result[$name] as $material => $_value) {
                    $_result[$count]['material'][] = array('name'=>$material);
                    $arrLength = count($_result[$count]['material']) - 1;
                    // Size去重
                    $result[$name][$material] = array_unique($result[$name][$material]);

                    foreach ($result[$name][$material] as $index => $size) {
                        if($_result[$count]['material'][$arrLength]['name'] == $material){
                            $_result[$count]['material'][$arrLength]['size'][] = array('name'=>$size);
                        }
                    }
                }
                $count += 1;
            }

            $noticeData = DB::table('data_notice_price')->get();

            return array('specsData'=>$_result, 'noticeData'=>$noticeData);

        }else{
            return 'Error';
        }
    }

    // 获取Setting的数据
    public function getDataFromSetting(){
        $brandSeting = DB::table('steel_products')->select('brand')->get();
        $_brandSeting = array();
        foreach ($brandSeting as $key=>$val) {
            $_brandSeting[] = $val->brand;
        }
        $brandSeting = array_values(array_unique($_brandSeting));
        // dd($brandSeting);
        // dd(array_unique($brandSeting));
        $priceSource = DataPriceSource::all();
        $transportTypeSeting = DB::table('settings')->where('key', 'transport_type')->get();
        $warehouseData = DB::table('data_warehouse')->get();
        $paymentKind = DB::table('dara_payment_kind')->get();
        $webDatas = DB::table('data_web_price_date')->orderBy('date', 'desc')->take(1)->get();
        $webDatas = DB::table('data_web_price')->where('file_name', $webDatas[0]->date)->get();

        $viewModel = array('brands'=>$brandSeting, 'price_source'=>$priceSource,'transport_type'=>$transportTypeSeting[0]->value, 'webDatas'=>$webDatas, 'warehouseData'=>$warehouseData, 'paymentKind'=>$paymentKind);

        return $viewModel;
    }

    // 获取指定日期的web价格和market价格
    public function getRecordFromDate(Request $request){

        if(!preg_match('/^\d{4}[\-](0?[1-9]|1[012])[\-](0?[1-9]|[12][0-9]|3[01])(\s+(0?[0-9]|1[0-9]|2[0-3])\:(0?[0-9]|[1-5][0-9])\:(0?[0-9]|[1-5][0-9]))?$/', $request->input('date') )){
            return "日期格式有误";
        }
        $marketData = DB::table('data_market_datas')->whereDate('created_at', $request->input('date'))->get();
        $webData = DB::table('data_web_price_date')->where('date', '>', strtotime($request->input('date')))->where('date', '<', (strtotime($request->input('date'))+86400))->get();

        foreach ($marketData as $key => $value) {
            $value->childData = (new DataMarketDatasChild())->getChildDataFromParentId($value->id);
        }

        foreach ($webData as $key => $value) {
            $value->childData = DB::table('data_web_price')->where('file_name', $value->date)->get();
        }

        return ['marketDatas'=>$marketData, 'webDatas'=>$webData];
    }

    // 获取最后一次报价
    public function getLastMarketPrice(Request $request){
        $parentData = DataMarketDatas::orderBy('id', 'desc')->take(2)->get();
        if($parentData[0]->display !== 0){
            $result = DataMarketDatasChild::where('parent_id', $parentData[0]->id)->get();
        }else{
            $result = DataMarketDatasChild::where('parent_id', $parentData[1]->id)->get();
        }
        return $result;
    }

    public function getPrveMarketData(Request $request){
        $newParentData = $this->createMarketRecord();

        $reqId = intval($newParentData['data']['id']);
        $prevId = $reqId;
        $prevParentId = [];
        $prevData = [];
        $inserData = [];

        while(count($prevParentId) == 0){
            $prevId--;
            $prevParentId = DataMarketDatas::where('id', $prevId)->where('display', 1)->get();
        }

        $prevData = DataMarketDatasChild::where('parent_id', $prevId)->select('brand', 'cate_spec', 'material', 'size', 'price', 'inventory', 'price_source', 'warehouse', 'transport', 'payment_kind', 'product_status')->get();

        foreach ($prevData as $key => $value) {
            $temp = $value['attributes'];
            $temp['parent_id'] = $reqId;
            $temp['writer_id'] = $request->getClientIp();
            $inserData[] = $temp;
            DataMarketDatasChild::create($temp);
        }
        // $result = DataMarketDatasChild::insert($inserData);

        return $newParentData;
    }

    // 删除市场价格
    public function delMarketDatas(Request $Request){
        // 硬删除
        // $result = DB::transaction(function()use($Request){
        //     DB::table('data_market_datas')->where('id', $Request->id)->delete();
        //     DB::table('data_market_datas_child')->where('parent_id', $Request->id)->delete();
        // });

        $result = DataMarketDatas::destroy($Request->id);
        if($result!=null){
            return "删除成功";
        }else{
            return "删除失败";
        }
    }

    // 发布报价信息
    public function reportMarketData(Request $Request){
        $result = DataMarketDatas::find($Request->id)->update(['display'=>1]);
        return $this->responseMsg($msg='发布成功', $status='success', $data=$result);
    }

    // 新增报价来源的厂商
    public function createPriceSource(Request $Request){
        $result = DataPriceSource::create(['name'=>$Request->name, 'company_type'=>$Request->type]);
        if($result){
            return $this->responseMsg($msg='修改成功', $status='success', $data=$result);
        }else{
            return $this->responseMsg($msg='修改无效', $status='error', $data='null');
        }
    }

    // 修改报价来源的厂商
    public function editPriceSource(Request $Request){
        $result = DataPriceSource::where('id', $Request->id)->update(['name'=>$Request->text, 'company_type'=>$Request->company_type]);
        if($result == 1){
            return $this->responseMsg($msg='修改成功', $status='success', $data='null');
        }else{
            return $this->responseMsg($msg='修改无效', $status='error', $data='null');;
        }
    }

    // 删除报价来源的厂商
    public function delPriceSource(Request $Request){
        $result = DataPriceSource::destroy($Request->id);
        if($result == 1){
            return $this->responseMsg($msg='删除成功', $status='success', $data='null');
        }else{
            return $this->responseMsg($msg='删除无效', $status='error', $data='null');
        }
    }

    // 创建仓库数据
    public function createWarehouse(Request $Request){
        $result = DataWarehouse::create(['warehouse_name'=>$Request->warehouseData]);
        if($result){
            return $this->responseMsg($msg='添加成功', $status='success', $data=$result);
        }else{
            return $this->responseMsg($msg='操作失败', $status='error', $data='null');
        }
    }

    // 修改仓库数据
    public function editWarehouse(Request $Request){
        $result = DataWarehouse::where('id', $Request->id)->update(['warehouse_name'=>$Request->warehouse_name]);
        if($result == 1){
            return $this->responseMsg($msg='修改成功', $status='success', $data='null');
        }else{
            return $this->responseMsg($msg='修改无效', $status='error', $data='null');;
        }
    }

    // 删除仓库数据
    public function delWarehouse(Request $Request){
        $result = DataWarehouse::destroy($Request->id);
        if($result == 1){
            return $this->responseMsg($msg='删除成功', $status='success', $data='null');
        }else{
            return $this->responseMsg($msg='删除无效', $status='error', $data='null');
        }
    }

    // 添加付款方式
    public function createPaymentKind(Request $Request){
        $result = DB::table('dara_payment_kind')->insertGetId(['payment_name'=>$Request->payment_name]);
        if($result!=0){
            return $this->responseMsg($msg='添加成功', $status='success', $data=$result);
        }else{
            return $this->responseMsg($msg='操作失败', $status='error', $data='null');
        }
    }

    // edit
    public function editPaymentKind(Request $Request){
        $result = DB::table('dara_payment_kind')->where('id', $Request->id)->update(['payment_name'=>$Request->payment_name]);
        if($result == 1){
            return $this->responseMsg($msg='修改成功', $status='success', $data='null');
        }else{
            return $this->responseMsg($msg='修改无效', $status='error', $data=$result);;
        }
    }

    // delete
    public function delPaymentKind(Request $Request){
        $result = DB::table('dara_payment_kind')->where('id', $Request->id)->delete();
        if($result == 1){
            return $this->responseMsg($msg='删除成功', $status='success', $data='null');
        }else{
            return $this->responseMsg($msg='删除无效', $status='error', $data='null');
        }
    }

    // 添加市场数据父表
    public function createMarketRecord(){
        // dd(DB::table('data_market_datas')->max('id'));
        // 判断报价次序
        $today = Carbon::today();
        $result = DataMarketDatas::whereDate('created_at', $today)->where('deleted_at', null)->get();

        // 插入市场数据表
        $insertData = array('price_queue'=>count($result));
        $resData = DataMarketDatas::create($insertData);
        return ['data'=>$resData];
    }

    // 添加市场价格数据
    public function createMarketPrice(Request $Request){
        // 检查是否已有相同报价
        $isReplace = false;
        $repordDatas = DataMarketDatasChild::where('parent_id', $Request->id)->each(function($item, $key)use($Request, &$isReplace){
            foreach ($Request->formData as $key => $value) {
                //  检查是否 品牌, 公司, 仓库, 付款方式相同
                if($value['brand'] == $item['brand'] && $value['price_source'] == $item['price_source'] && $value['warehouse'] == $item['warehouse'] && $value['payment_kind'] == $item['payment_kind'] ){
                    // 检查是否规格相同
                    if($value['cate_spec'] == $item['cate_spec'] && $value['material'] == $item['material'] && $value['size'] == $item['size'] ){
                        $isReplace = true;
                    }
                }
            }
        });
        if($isReplace){
            return $this->responseMsg($msg='已有另外的人录入相同的数据, 禁止再次录入, 请刷新后核对', $status='error', $data='null');
        }


        $parentId = $Request->id;
        if($parentId){
            // 插入市场数据子表
            $_insertData = array();
            foreach ($Request->formData as $key => $value) {
                DataMarketDatasChild::create( array('parent_id'=>$parentId, 'brand'=>$value['brand'], 'cate_spec'=>$value['cate_spec'], 'material'=>$value['material'], 'size'=>$value['size'],
                    'price'=>$value['price'], 'inventory'=>$value['inventory'], 'price_source'=>$value['price_source'], 'warehouse'=>$value['warehouse'], 'transport'=>$value['transport'], 'payment_kind'=>$value['payment_kind'], 'product_status'=>$value['product_status'], 'writer_id'=>$Request->getClientIp() ) );
            }

            // 插入或更新品牌资源表的平均值
            $this->getBrandDataMean($Request);
            return $this->responseMsg($msg='添加报价成功', $status='success', $data='null');

        }else{
            return $this->responseMsg($msg='操作失败', $status='error', $data='null');
        }
    }

    // 添加市场价格数据
    public function fillMarketPrice(Request $Request){
        $oldRecordDate = DataMarketDatasChild::where('parent_id', $Request->data[0]['parent_id'])->first();
        $oldRecordDate = date($oldRecordDate->created_at);

        // 插入市场数据子表
        $_insertData = array();
        $result = array();
        foreach ($Request->data as $key => $value) {
            $result[] = DataMarketDatasChild::create( array('parent_id'=>$value['parent_id'], 'brand'=>$value['brand'], 'cate_spec'=>$value['cate_spec'], 'material'=>$value['material'], 'size'=>$value['size'],
                'price'=>$value['price'], 'inventory'=>$value['inventory'], 'price_source'=>$value['price_source'], 'warehouse'=>$value['warehouse'], 'transport'=>$value['transport'], 'payment_kind'=>$value['payment_kind'], 'product_status'=>$value['product_status'], 'writer_id'=>$Request->getClientIp(), 'created_at'=>$oldRecordDate ) );
        }

        // 插入或更新品牌资源表的平均值
        // $this->getBrandDataMean($Request->data);
        return $this->responseMsg($msg='添加报价成功', $status='success', $data=$result);

    }


    // 获取市场数据列表
    public function getListData(){
        $marketDatas = DataMarketDatas::orderBy('created_at', 'desc')->paginate(3);
        return $this->responseMsg($msg='null', $status='success', $data=$marketDatas);
    }

    public function getMarketData(Request $Request){
        // 获取View控件的数据
        $brandSeting = DB::table('steel_products')->select('brand')->get();
        $_brandSeting = array();
        foreach ($brandSeting as $key=>$val) {
            $_brandSeting[] = $val->brand;
        }
        $brandSeting = array_values(array_unique($_brandSeting));
        $priceSource = DataPriceSource::all();
        $transportTypeSeting = DB::table('settings')->where('key', 'transport_type')->get();
        $priceQueueSeting = DB::table('settings')->where('key', 'price_queue')->get();
        // View控件的数据
        $viewModel = array('brands'=>$brandSeting, 'price_source'=>$priceSource,'transport_type'=>$transportTypeSeting[0]->value, 'price_queue'=>$priceQueueSeting[0]->value);

        // 获取该次请求的市场数据
        $parentData = DataMarketDatas::find($Request->id);
        $childData = DataMarketDatasChild::where('parent_id', $parentData->id)->get();

        // 品名和材质去重
        $result = [];
        foreach ($childData as $key => $value) {
            $result[$value['brand']][$value['price_source']][$value['warehouse']][$value['cate_spec']][$value['material']][] = array('id'=>$value['id'], 'brand'=>$value['brand'], 'size'=>$value['size'], 'price'=>$value['price'], 'inventory'=>$value['inventory'], 'transport'=>$value['transport'], 'product_status'=>$value['product_status'], 'warehouse'=>$value['warehouse']);
        }

        // 组合成树形结构数据
        $_result = [];
        foreach ($result as $name => $value) {
            $tempArr = ['name'=>$name, 'data'=>array()];
            foreach ($value as $sourceName => $steelValue) {
                $warehouseArr = [];
                foreach ($steelValue as $warehousekey => $warehouse) {
                    $steelArr = [];
                    foreach ($warehouse as $steelName => $material) {
                        $materialArr = [];
                        foreach ($material as $materialName => $size) {
                            $materialArr[] = ['name'=>$materialName, 'size'=>$size];
                        }
                        $steelArr[] = ['name'=>$steelName, 'material'=>$materialArr];
                    }
                    $warehouseArr[] = ['name'=>$warehousekey, 'steelData'=>$steelArr];
                }
                $tempArr['data'][] = ['name'=>$sourceName,'data'=>$warehouseArr];
            }
            $_result[] = $tempArr;
        }

        foreach ($_result as $key => $value) {
            foreach ($_result[$key]['data'] as $_key => $_value) {
                foreach ($childData as $line => $baseData) {
                    if($baseData->brand==$value['name'] && $baseData->price_source==$_value['name']){
                        $_result[$key]['data'][$_key]['transport'] = $baseData->transport;
                        $_result[$key]['data'][$_key]['payment_kind'] = $baseData->payment_kind;
                        $_result[$key]['data'][$_key]['warehouse'] = $baseData->warehouse;
                        break;
                    }
                }
            }
        }

        $result = array('viewData'=>$viewModel, 'parentData'=>$parentData, 'childData'=>$_result, 'isAdmin'=>Auth::user()->hasRole('admin'), 'created_at'=>$parentData->created_at);
        return $this->responseMsg($msg='null', $status='success', $data=$result);
    }

    public function editMarketData(Request $Request){
        $result = DB::transaction(function()use($Request){
            $childData = $Request->updateData;
            // 更新子节点数据
            foreach ($childData as $key => $value) {
                if($value['price'] != null){
                    DataMarketDatasChild::find($value['id'])->update($value);
                }else{
                    DataMarketDatasChild::destroy($value['id']);
                }
            }
        });

        return $this->responseMsg($msg='修改成功', $status='success', $data='null');
    }

    // 获取日期内的市场价格
    public function getMarketDatasAtDate(Request $Request){
        $date = $Request->date;
        $result = DataMarketDatas::whereDate('created_at', $date)->where("display", 1)->get();
        return $result;
    }

    // 添加运费价格
    public function createFreightPrice(Request $Request){
        $data = array('type'=>$Request->type, 'transport_price'=>$Request->transport_price, 'transport_count'=>$Request->transport_count,
            'transport_car_price'=>$Request->transport_car_price, 'brand'=>$Request->brand, 'size'=>json_encode($Request->size), 'city'=>$Request->city, 'area'=>$Request->area,
            'address'=>$Request->address, 'remarks'=>$Request->remarks);
        $result = DataTransport::create($data);

        if($result){
            return $this->responseMsg($msg='添加成功', $status='success', $data='null');
        }else{
            return $this->responseMsg($msg='操作失败', $status='error', $data='null');
        }
    }

    // 获取运费价格
    public function getFreightPrice(){
        return $this->responseMsg($msg='null', $status='success', $data=DataTransport::get());
    }

    // 修改运费价格
    public function editFreightPrice(Request $Request){
        $saveData = $Request->all();
        unset($saveData['_token']);

        $saveData['size'] = json_encode($Request->size);
        $result = DataTransport::find($Request->id)->update($saveData);
        if($result == 1){
            return $this->responseMsg($msg='修改成功', $status='success', $data='null');
        }else{
            return $this->responseMsg($msg='操作失败', $status='error', $data='null');
        }
    }

    // 删除运费价格
    public function delFreightPrice(Request $Request){
        $result = DataTransport::destroy($Request->id);
        if($result == 1){
            return $this->responseMsg($msg='删除成功', $status='success', $data='null');
        }else{
            return $this->responseMsg($msg='操作失败', $status='error', $data='null');
        }
    }



// 钢材每日价格模块

    // 获取钢材价格列表
    public function getSteelMarketList(){
        $result['steelMarketList'] = DataMarketDatas::where('display', 1)->orderBy('created_at', 'desc')->get();
        $result['userProjectInfo'] = $this->getProjectFromeUser(Auth::user()['id']);

        return $this->responseMsg($msg='null', $status='success', $data=$result);
    }

    // 获取用户拥有的项目
    public function getProjectFromeUser($userId){
        return DB::table('project')->where('user_id', $userId)->get();
    }

    public function getSteelMarketDatas(Request $Request){

        $parentResult = DataMarketDatas::where('id', $Request->id)->get();
        $childResult = (new MarketDataHandleController())->marketDataHandle(DB::table('data_market_datas_child')->where('parent_id', $Request->id)->get());

        // 获取数据创建当天的网价
        $createdDate = substr($parentResult[0]->created_at,0 ,10);
        $searchdTime = strtotime($createdDate);
        $endTime = strtotime($createdDate) + 86400;

        // 获取网价数据
        $webDatas = DB::table('data_web_price')->whereBetween('file_name', [$searchdTime, $endTime])->get();

        // 获取配送方式
        $brands = [];
        foreach ($childResult as $key => $value) {
            $brands[] = $value->brand;
        }
        $brands = array_values(array_unique($brands));
        $transportType = [];
        foreach ($brands as $key => $value) {
            $result = DB::table('data_transport')->where('brand', $value)->get();
            if(count($result) == 0){
                $transportType[] = ['type'=>1, 'brand'=>$value];
            }else{
                $transportType[] = ['type'=>2, 'brand'=>$value];
            }

        }

        $result = ['parentResult'=>$parentResult, 'childResult'=>$childResult, 'webDatas'=>$webDatas, 'transportType'=>$transportType];
        return $this->responseMsg($msg='null', $status='success', $data=$result);
    }

    // 查询送到价格
    public function searchTransportForCity(Request $Request){
        $targetData = $Request->all();
        $data = [];
        foreach ($Request->brands as $key => $value) {
            $result = DB::table('data_transport')->where('brand', $value)->where('city', $targetData['city'])->where('area', $targetData['area'])->get();
            if(count($result) === 0){
                $data[] = ['brand'=>$value, 'data'=>DB::table('data_transport')->where('type', 1)->where('city', $targetData['city'])->where('area', $targetData['area'])->get()];
            }else{
                $data[] = ['brand'=>$value, 'data'=>DB::table('data_transport')->where('brand', $value)->where('city', $targetData['city'])->where('area', $targetData['area'])->get()];
            }
        }
        return $data;
    }

// 资源推荐模块

    // 获取资源推荐页面数据
    public function getRecommendingResource(){

        $specs = DB::table('steel_products')->get();
        $result=array();
        $_result=array();

        // 品名和材质去重
        foreach ($specs as $key => $value) {
            $result[$value->brand][$value->cate_spec][$value->material][]=$value->size;
        }

        // 近三个月的每月平均价格
        $resourceData = DB::table('data_brand_resource')->get();
        foreach ($result as $key => $steelVal) {
            $isAdd = true;
            foreach ($resourceData as $index => $resource) {
                if($key == $resource->brand){
                    $_result[] = ['brand'=>$key, 'steel'=>$steelVal, 'resourceDatas'=>json_decode($resource->mean_of_months)];
                    $isAdd = false;
                    break;
                }
            }
            if($isAdd){
                $_result[] = ['brand'=>$key, 'steel'=>$steelVal, 'resourceDatas'=>null];
            }
        }

        // 到广州的运费数据
        $ctiyTransport = $this->getTransportPrice($city='广州市');
        // dd($ctiyTransport);

        // $parentData = DB::table('data_market_datas')->orderBy('created_at', 'desc')->first();
        // $data = DB::table('data_market_datas_child')->select('inventory')->where('parent_id', $parentData->id)->get();
        // 手动分页
        // $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // $collection = new Collection($data);
        // $perPage = 3;
        // $currentPageSearchResults = $collection->slice($currentPage * $perPage, $perPage)->all();
        // $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
        $responeseData = ['brandData'=>$_result, 'transportData'=>$ctiyTransport];
        return $responeseData;
    }

    // 获取到某地区的运费
    public function getTransportPrice($city, $area=0){
        if($area === 0){
            $result = DB::table('data_transport')->where('city', $city)->get();
        }else{
            $result = DB::table('data_transport')->where('city', $city)->where('area', $area)->get();
        }
        return $result;
    }

    // 在后台管理界面新增数据时, 抽出需要计算平均数的数据
    public function getBrandDataMean($Request){
        $nowTimeHandle = Carbon::now();
        // 现在时间, 本月时间, 第二月份, 第三月份
        $nowTime = date($nowTimeHandle);
        $nowMonth = substr(date($nowTimeHandle), 0, 7).'-01 00:00:00';
        $threeMonth = date($nowTimeHandle->subMonth(2)->startOfMonth());
        $secondMonth = date($nowTimeHandle->addMonth(1)->startOfMonth());
        // dd($nowTime,$nowMonth, $secondMonth, $threeMonth);

        // 获得需要更新的品牌
        $marketDatas = $Request->formData;
        $changeBrands = [];
        foreach ($marketDatas as $key => $value) {
            $changeBrands[] = $value['brand'];
        }
        $changeBrands = array_values(array_unique($changeBrands));


        // 获取三个月内发布市场价格的列表
        $firstMonthDatas = DB::table('data_market_datas')->whereBetween('created_at', [$nowMonth, $nowTime])->get();
        $secondMonthDatas = DB::table('data_market_datas')->whereBetween('created_at', [$secondMonth, $nowMonth])->get();
        $threeMonthDatas = DB::table('data_market_datas')->whereBetween('created_at', [$threeMonth, $secondMonth])->get();

        // 获取第一月份对应品牌18-25规格的每次报价平均数
        $firstMean = [];
        foreach ($changeBrands as $key => $brand) {
            $tempArr = ['brand'=>$brand, 'mean'=>array()];
            foreach ($firstMonthDatas as $key => $value) {
                $mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400')->avg('price');
                $_mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400E')->avg('price');
                 $tempArr['mean'][] = ['mean'=>$mean, '_mean'=>$_mean, 'created_at'=>$firstMonthDatas[0]->created_at];
            }
            $firstMean[] = $tempArr;
        }

        // 获取第二月份对应品牌18-25规格的每次报价平均数
        $secondMean = [];
        foreach ($changeBrands as $key => $brand) {
            $tempArr = ['brand'=>$brand, 'mean'=>array()];
            foreach ($secondMonthDatas as $key => $value) {
                $mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400')->avg('price');
                $_mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400E')->avg('price');
                $tempArr['mean'][] = ['mean'=>$mean, '_mean'=>$_mean, 'created_at'=>$secondMonthDatas[0]->created_at];
            }
            $secondMean[] = $tempArr;

        }

        // 获取第三月份对应品牌18-25规格的每次报价平均数
        $threeMean = [];
        foreach ($changeBrands as $key => $brand) {
            $tempArr = ['brand'=>$brand, 'mean'=>array()];
            foreach ($threeMonthDatas as $key => $value) {
                $mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400')->avg('price');
                $_mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400E')->avg('price');

                $tempArr['mean'][] = ['mean'=>$mean, '_mean'=>$_mean, 'created_at'=>$threeMonthDatas[0]->created_at];
            }
            $threeMean[] = $tempArr;
        }


        // 计算每个品牌的每月平均数
        $allMeanData = [$firstMean, $secondMean, $threeMean];
        $meanMonth = [];
        foreach ($changeBrands as $key => $brand) { // 遍历更新的品牌
            $brandMean = [];
            foreach ($allMeanData as $index => $monthsData) { // 遍历三个月数据父节点
                foreach ($monthsData as $_index => $brandDatas) { // 遍历三个月数据子节点
                    if($brandDatas['brand'] == $brand && isset($brandDatas['mean'])){
                        // 是需要更新的品牌 & 此月数据不为空
                        $mean = 0; $_mean = 0;
                        $count = 0; $_count = 0;

                        foreach ($brandDatas['mean'] as $index => $meanData) {
                            $mean += $meanData['mean'];
                            $_mean += $meanData['_mean'];
                            if($meanData['mean'] != null){
                                $count++;
                            }
                            if($meanData['_mean'] != null){
                                $_count++;
                            }
                        }
                        if(count($brandDatas['mean']) !== 0){
                            $brandMean[] = ['brand'=>$brandDatas['brand'], 'material'=>$mean/($count==0? 1 : $count), '_material'=>$_mean/($_count==0? 1 : $_count), 'created_at'=>$brandDatas['mean'][0]['created_at']];
                        }
                    }
                }
            }
            krsort($brandMean);
            $meanMonth[] = array_values($brandMean);
        }

        foreach ($meanMonth as $key => $brandMeanOfMonths) {
            $result = DB::table('data_brand_resource')->where('brand', $brandMeanOfMonths[0]['brand'])->get();
            if(count($result) == 0){
                // 若没有改数据则写入
                $result = DB::table('data_brand_resource')->where('brand', $brandMeanOfMonths[0]['brand'])->insert([
                    'brand'=>$brandMeanOfMonths[0]['brand'],
                    'mean_of_months'=> json_encode($brandMeanOfMonths)
                ]);
            }else{
                // 更新数据库
                $result = DB::table('data_brand_resource')->where('brand', $brandMeanOfMonths[0]['brand'])->update(['mean_of_months'=> json_encode($brandMeanOfMonths)]);
            }
        }
    }

    public function updateBrandDataMeansSelf(){
        $nowTimeHandle = Carbon::now();
        // 现在时间, 本月时间, 第二月份, 第三月份
        $nowTime = date($nowTimeHandle);
        $nowMonth = substr(date($nowTimeHandle), 0, 7).'-01 00:00:00';
        $threeMonth = date($nowTimeHandle->subMonth(2)->startOfMonth());
        $secondMonth = date($nowTimeHandle->addMonth(1)->startOfMonth());
        // dd($nowTime,$nowMonth, $secondMonth, $threeMonth);

        // 获得需要更新的品牌
        $changeBrands = [];
        foreach ((DB::table('steel_factorys')->select('abbreviation')->get()) as $key => $value) {
            $changeBrands[] = $value->abbreviation;
        }
        $changeBrands = ["桂鑫"];

        // 获取三个月内发布市场价格的列表
        $firstMonthDatas = DB::table('data_market_datas')->whereBetween('created_at', [$nowMonth, $nowTime])->get();
        $secondMonthDatas = DB::table('data_market_datas')->whereBetween('created_at', [$secondMonth, $nowMonth])->get();
        $threeMonthDatas = DB::table('data_market_datas')->whereBetween('created_at', [$threeMonth, $secondMonth])->get();

        // 获取第一月份对应品牌18-25规格的每次报价平均数
        $firstMean = [];
        foreach ($changeBrands as $key => $brand) {
            $tempArr = ['brand'=>$brand, 'mean'=>array()];
            foreach ($firstMonthDatas as $key => $value) {
                $mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400')->avg('price');
                $_mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400E')->avg('price');

                $tempArr['mean'][] = ['mean'=>$mean, '_mean'=>$_mean, 'created_at'=>$firstMonthDatas[0]->created_at];
            }
            $firstMean[] = $tempArr;
        }

        // 获取第二月份对应品牌18-25规格的每次报价平均数
        $secondMean = [];
        foreach ($changeBrands as $key => $brand) {
            $tempArr = ['brand'=>$brand, 'mean'=>array()];
            foreach ($secondMonthDatas as $key => $value) {
                $mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400')->avg('price');

                $_mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400E')->avg('price');

                $tempArr['mean'][] = ['mean'=>$mean, '_mean'=>$_mean, 'created_at'=>$secondMonthDatas[0]->created_at];
            }
            $secondMean[] = $tempArr;

        }

        // 获取第三月份对应品牌18-25规格的每次报价平均数
        $threeMean = [];
        foreach ($changeBrands as $key => $brand) {
            $tempArr = ['brand'=>$brand, 'mean'=>array()];
            foreach ($threeMonthDatas as $key => $value) {
                $mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400')->avg('price');
                $_mean = DB::table('data_market_datas_child')->where('parent_id', $value->id)->where('brand', $brand)->whereBetween('size', ['18', '25'])->where('material', 'HRB400E')->avg('price');

                $tempArr['mean'][] = ['mean'=>$mean, '_mean'=>$_mean, 'created_at'=>$threeMonthDatas[0]->created_at];
            }
            $threeMean[] = $tempArr;
        }


        // 计算每个品牌的每月平均数
        $allMeanData = [$firstMean, $secondMean, $threeMean];
        $meanMonth = [];
        foreach ($changeBrands as $key => $brand) { // 遍历更新的品牌
            $brandMean = [];
            foreach ($allMeanData as $index => $monthsData) { // 遍历三个月数据父节点
                foreach ($monthsData as $_index => $brandDatas) { // 遍历三个月数据子节点
                    if($brandDatas['brand'] == $brand && isset($brandDatas['mean'])){
                        // 是需要更新的品牌 & 此月数据不为空
                        $mean = 0; $_mean = 0;
                        $count = 0; $_count = 0;

                        foreach ($brandDatas['mean'] as $index => $meanData) {
                            $mean += $meanData['mean'];
                            $_mean += $meanData['_mean'];
                            if($meanData['mean'] != null){
                                $count++;
                            }
                            if($meanData['_mean'] != null){
                                $_count++;
                            }
                        }
                        if(count($brandDatas['mean']) !== 0){
                            $brandMean[] = ['brand'=>$brandDatas['brand'], 'material'=>$mean/($count==0? 1 : $count), '_material'=>$_mean/($_count==0? 1 : $_count), 'created_at'=>$brandDatas['mean'][0]['created_at']];
                        }
                    }
                }
            }
            krsort($brandMean);
            $meanMonth[] = array_values($brandMean);
        }

        foreach ($meanMonth as $key => $brandMeanOfMonths) {
            $result = DB::table('data_brand_resource')->where('brand', $brandMeanOfMonths[0]['brand'])->get();
            if(count($result) == 0){
                // 若没有改数据则写入
                $result = DB::table('data_brand_resource')->where('brand', $brandMeanOfMonths[0]['brand'])->insert([
                    'brand'=>$brandMeanOfMonths[0]['brand'],
                    'mean_of_months'=> json_encode($brandMeanOfMonths)
                ]);
            }else{
                // 更新数据库
                $result = DB::table('data_brand_resource')->where('brand', $brandMeanOfMonths[0]['brand'])->update(['mean_of_months'=> json_encode($brandMeanOfMonths)]);
            }
        }
    }

    // 添加本月的平均数
    public function updateMeanOneMonth($brand, $oneMonthDatas){
        // 更新数据库
        $hasData = count(DB::table('data_brand_resource')->where('brand', $brand)->get());
        if($hasData == 0){
            // 若没有数据改数据则写入
            $result = DB::table('data_brand_resource')->where('brand', $brand)->insert([
                'brand'=>$brand,
                'mean_of_one_month'=> json_encode($oneMonthDatas)
            ]);
        }else{
            $result = DB::table('data_brand_resource')->where('brand', $brand)->update(['mean_of_one_month'=> json_encode($oneMonthDatas)]);
        }

        return intval($result);
    }

    public function brandsDiff(Request $Request){
        // dd($Request->brands);
        $allBrandsData = [];
        foreach ($Request->brands as $key => $brand) {
            $specs = DB::table('steel_products')->where('brand', $brand)->get();
            $result=array();
            $_result=array();

            // 品名和材质去重
            foreach ($specs as $key => $value) {
                $result[$value->brand][$value->cate_spec][$value->material][]=$value->size;
            }

            // 近三个月的每月平均价格
            $resourceData = DB::table('data_brand_resource')->get();
            foreach ($result as $key => $steelVal) {
                $isAdd = true;
                foreach ($resourceData as $index => $resource) {
                    if($key == $resource->brand){
                        $_result[] = ['brand'=>$key, 'steel'=>$steelVal, 'resourceDatas'=>json_decode($resource->mean_of_months)];
                        $isAdd = false;
                        break;
                    }
                }
                if($isAdd){
                    $_result[] = ['brand'=>$key, 'steel'=>$steelVal, 'resourceDatas'=>null];
                }
            }

            // 到广州的运费数据
            $ctiyTransport = DB::table('data_transport')->where('city', '广州市')->get();

            $allBrandsData[] = $responeseData = ['brandData'=>$_result, 'transportData'=>$ctiyTransport];
        }

        return $allBrandsData;
    }

    // 风险提示 新增规则
    public function createPriceNotice(Request $Request){
        $result = DB::table('data_notice_price')->insertGetId($Request->all());
        if($result>0){
            return $result;
        }
    }

    // 获取风险提示数据 与 规格数据
    public function getNoticeDatas(Request $Request){
        return array('brandsTreeData'=>$this->getAllbrands(), 'noticeDatas'=>DB::table('data_notice_price')->get());
    }

    // 修改数据
    public function editNoticeDatas(Request $Request){
        $result = DB::table('data_notice_price')->where('id', $Request->id)->update([
            'brand'=>$Request->name,
            'cate_spec'=>$Request->description,
            'material'=>$Request->material,
            'size'=>$Request->norms,
            'transport_type'=>$Request->transport_type,
            'maxNumber'=>$Request->maxNumber,
            'minNumber'=>$Request->minNumber
        ]);
        return $result;
    }

    // del data
    public function deleteNoticeDatas(Request $Request){
        $result = DB::table('data_notice_price')->where('id', $Request->id)->delete();
        return $result;
    }


    public function searchTransportDatas($target){
        if(is_array($target)){

        }else{
            return false;
        }
    }

    public function showTable(){
        $number = [1,2,3];
        print_r([1,5,7]);
        return 1;
    }

    public function getAllbrands(){
        $brands =  DB::table('steel_factorys')->select('abbreviation')->get()->toArray();
        $result = [];
        foreach ($brands as $key => $value) {
            $result[] = $value->abbreviation;
        }
        return $result;
    }

    public function getAllBrandsWillHeader(){
        return response($this->getAllbrands());
    }

    public function getAllHasbrands(){
        $brands = DB::table('steel_products')->select('brand')->distinct('brand')->get();
        return $brands;
    }

    public function responseMsg($msg, $status, $data){
        $responseMsg = array('message'=>$msg, 'status'=>$status, 'data'=>$data);
        return $responseMsg;
    }

    public function updateCatchData(Request $Request){
        $time = $Request->time;
        $handle = fopen("./websteel/websteel/catchData/updateData.json", "r");
        $data = json_decode(fread($handle,filesize("./websteel/websteel/catchData/updateData.json")));
        fclose($handle);

        $isSaved = empty(DB::table('data_web_price_date')->where('date', $time)->get()->toArray());
        if($isSaved){
            if( DB::table('data_web_price_date')->insert(["date"=>$time]) ){
            $insertData = [];
            foreach ($data as $key => $value) {
                $insertData[] = ['file_name'=>$time, "product"=>$value[0], "type"=>$value[1], "material"=>$value[2], "brands"=>$value[3], "web_price"=>$value[4], "price_change"=>$value[5], "source_states"=>$value[6]];
            }
            DB::table('data_web_price')->insert($insertData);

                return "OK";
            }else{
                return "ERROR";
            }
        }else{
            return "Data is replace !!!";
        }

    }

}
