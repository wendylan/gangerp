<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;

class DataMarketRule extends Model
{
    //
    protected $table = 'data_market_rule';

    //模型关系
    public function brand(){
    	return $this->belongsTo('App\Models\Steel_factory', 'brand_id');
    }

    // 获取所有相关的价格规则-test2
    static function fullDatas(){
    	$datas = self::join('steel_factorys', 'data_market_rule.brand_id', 'steel_factorys.id')
    		->select('abbreviation', 'active_rule')
    		->get()->toArray();
    	return $datas;
    }

}
