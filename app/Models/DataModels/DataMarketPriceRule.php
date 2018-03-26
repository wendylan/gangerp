<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;

class DataMarketPriceRule extends Model
{
    //
    protected $table = 'data_market_price_rule';

    //模型关系
    public function steel(){
    	return $this->belongsTo('App\Models\Steel_products', 'steel_products_id');
    }

    public function supplier(){
    	return $this->belongsTo('App\Models\DataModels\DataPriceSource', 'supplier_id');
    }
}
