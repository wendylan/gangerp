<?php

namespace App\Http\Controllers\v1;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Steel_products;
use App\Models\DataModels\DataPaymentKind;
use App\Models\DataModels\DataMarketDatas;
use App\Models\DataModels\DataMarketDatasChild;
use App\Models\DataModels\DataMarketPriceRule;
use App\Models\DataModels\DataPriceSource;
use App\Models\DataModels\DataMarketRule;


class DataMarketPriceController extends BaseController{

    //admin市场价格页面, 初始化数据
    public function getInitDatas(Request $request){
        if(!isset($request->date)){
            $request->date = Carbon::today()->toDateString();
        }

        $suppiler = DB::table('data_price_source')->get()->toArray();
        $brands = DB::table('steel_factorys')->get()->toArray();
        $warehouse = DB::table('data_warehouse')->get()->toArray();
        $payment = DB::table('dara_payment_kind')->select('id', 'payment_name')->get()->toArray();

        $firstTime = Carbon::parse($request->date." 14:30:00");
        $secondTime = Carbon::parse($request->date." 16:30:00");
        $markets = (new DataMarketDatasChild)->getMarketPriceByDate($request->date);
        $treeInit = [];
        foreach ($markets as $key => $value) {
            $treeInit[$value['brand']][$value['price_source']][] = $value['warehouse'];
        }
        $treeModel = [];
        foreach ($treeInit as $key => $valueArr) {
            $suppliers = [];
            foreach ($valueArr as $index => $val) {
                $suppliers[] = ['name'=>$index, 'childs'=>array_values(array_unique($val))];
            }
            $treeModel[] = ['name'=>$key, 'childs'=>$suppliers];
        }
        return $this->responseBuild(['marketDatas'=>$markets, 'treeModel'=>$treeModel, 'suppliers'=>$suppiler, 'brands'=>$brands, 'warehouses'=>$warehouse, 'payment'=>$payment]);
    }

    // 筛选指定日期内数据
    // 筛选选项 , 品牌，供应商，仓库
    public function getMarketPriceBySteelAndDate(Request $request){
        $date = isset($request->date) ? $request->date : Carbon::today()->toDateString();
        $brand = $request->brand;
        $supplier = $request->supplier;
        $warehouse = $request->warehouse;

        $marketPriceDatas = DataMarketDatasChild::getNewlyDatasByBrand($date, $brand, $supplier, $warehouse);
        $allDatasOfBrand = Steel_products::where('brand', $brand)->get();

        $result = [
            'marketDatas' => $marketPriceDatas['newlyDatas'],
            'maxIndex' => $marketPriceDatas['maxIndex'],
            'tableDatas' => $marketPriceDatas['tableDatas']
        ];
        return $this->responseBuild($result);
    }

    // 录入市场数据价格
    public function add(Request $request){
        $postDatas = $request->postDatas;
        $saveDatas = [];

        foreach ($postDatas as $key => $value) {
            // 删除id并计算更新次数
            unset($postDatas[$key]['id']);
            $postDatas[$key]['times'] = (int)$value['times'] + 1;
            $postDatas[$key]['parent_id'] = 0;
            $saveDatas[] = $postDatas[$key];
        }

        $result = DataMarketDatasChild::insert($saveDatas);

        return $this->responseBuild($result);
    }

    public function buildMarketDatasReport(){
        DataMarketDatas::createMarketReport();
    }

}
