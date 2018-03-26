<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DataModels\DataMarketDatas;
use App\Models\DataModels\DataMarketDatasChild;

class DataMarketDatasChild extends Model
{
	// use SoftDeletes;
    protected $table = 'data_market_datas_child';
    // protected $dates = ['deleted_at'];
    protected $guarded = [];

    //  根据父Id返回关联的子数据
    // @param 父Id
    public function getChildDataFromParentId($parentId, $type='collection'){
        if($type == 'collection'){
            return DataMarketDatasChild::where('parent_id', $parentId)->get();
        }else{
            return DataMarketDatasChild::where('parent_id', $parentId)->get()->toArray();
        }
    }

    // 插入Array到Market价格
    public function scopeInsertDatas($query, $parentId, $inserDatas){
        foreach ($inserDatas as $key => $value) {
            DataMarketDatasChild::create( array('parent_id'=>$parentId, 'brand'=>$value['brand'], 'cate_spec'=>$value['cate_spec'], 'material'=>$value['material'], 'size'=>$value['size'],
                'price'=>$value['price'], 'inventory'=>$value['inventory'], 'price_source'=>$value['price_source'], 'warehouse'=>$value['warehouse'], 'transport'=>$value['transport'], 'payment_kind'=>$value['payment_kind'], 'product_status'=>$value['product_status'], 'writer_id'=>null ) );
        }
    }

    // copy指定父Id关联的子数据(copy不包含Id, parentId), 可选是否添加到指定的parentId
    // @param 被复制数据的父id  被添加数据的父Id
    public function scopeCopyLastDatasFromParentId($query, $parentId, $newParentId=null){
        $childDatas = DataMarketDatasChild::where('parent_id', $parentId)->select('brand', 'cate_spec', 'material', 'size', 'price', 'inventory', 'price_source', 'warehouse', 'transport', 'payment_kind', 'product_status')->get();
        if($newParentId){
            $result = [];
            foreach ($childDatas as $key => $value) {
                $temp = $value['attributes'];
                $temp['parent_id'] = $newParentId;
                $result[] = $temp;
            }
            return $result;
        }else{
            return $childDatas;
        }
    }
    //按日期获取报价
    //参数Date or String 参数格式 ('1993-07-01')
    //返回值 DataMarketDatasChild集合
    public function getMarketPriceByDate($date){
        return DataMarketDatasChild::where('created_at','like',$date.'%')->get();
    }

    // admin - 获取目前(最新)市场数据
    // 参数 : 日期、品牌、供应商、仓库
    static function getNewlyDatasByBrand($date, $brand, $supplier, $warehouse){
        $datasByBrand = DataMarketDatasChild::whereDate('created_at', $date)
                            ->where("brand", $brand)
                            ->where("price_source", $supplier)
                            ->where("warehouse", $warehouse)
                            ->get()->toArray();

        $newlyDatas = self::makeNewlyDatas($datasByBrand);
        $tableDatas = self::makeTableDatas($newlyDatas);

        $arr = [];
        foreach ($newlyDatas as $key => $value) {
            if(count($value)>0){
                $arr[] = $value[count($value)-1];
            }else{
                $arr[] = $value[0];
            }
        }
        $newlyDatas = $arr;

        return [ 'newlyDatas'=>$newlyDatas, 'maxIndex'=>$tableDatas['maxIndex'], 'tableDatas'=>$tableDatas['datas'] ];
    }

    // 合并多条相同规格报价，仅取最新报价
    static function makeNewlyDatas($databaseDatas){
        $result = [];
        while(count($databaseDatas)>0){
            $lineData = array_splice($databaseDatas, 0, 1);
            for ($i=0; $i<count($databaseDatas); $i++) {
                if(
                    $lineData[0]['brand']==$databaseDatas[$i]['brand'] &&
                    $lineData[0]['cate_spec']==$databaseDatas[$i]['cate_spec'] && 
                    $lineData[0]['material']==$databaseDatas[$i]['material'] && 
                    $lineData[0]['size']==$databaseDatas[$i]['size'] &&
                    $lineData[0]['warehouse']==$databaseDatas[$i]['warehouse']
                ){
                    $lineData = array_merge($lineData, array_splice($databaseDatas, $i, 1));
                    $i--;
                }
            }
            $result[] = $lineData;
        }
        return $result;
    }

    // 生成表格数据，包含相同规格的多次报价
    static function makeTableDatas($databaseDatas){
        $result = [];
        $maxIndex = 0;
        foreach ($databaseDatas as $key => $value) {
            if(count($value) > $maxIndex){
                $maxIndex = count($value);
            }
            $rootData = $value[0];
            foreach ($value as $index => $val) {
                $rootData['price_'.($index+1)] = $val['price'];
            }
            $result[] = $rootData;
        }
        return [ 'maxIndex'=>$maxIndex, 'datas'=>$result ];
    }

}
