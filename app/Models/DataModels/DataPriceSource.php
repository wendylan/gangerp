<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataPriceSource extends Model
{
	use SoftDeletes;
    //
    protected $table = 'data_price_source';
    protected $dates = ['deleted_at'];
    protected $guarded = [];

}
