<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DataModels\DataMarketDatas;
use App\Models\DataModels\DataMarketDatasChild;

class DataMarketDatasChild extends Model
{
	// use SoftDeletes;
    //
    protected $table = 'data_market_datas_child';
    // protected $dates = ['deleted_at'];
    protected $guarded = [];

    //  根据父Id返回关联的子数据
    // @param 父Id
    public function getChildDataFromParentId($parentId){
    	return DataMarketDatasChild::where('parent_id', $parentId)->get();
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
    //按时间获取报价
    //参数Date or String 参数格式 ('1993-07-01')
    //返回值 DataMarketDatasChild集合
    public function getMarketPriceByDate($date){
        return DataMarketDatasChild::where('created_at','like',$date.'%')->get();
    }
}
