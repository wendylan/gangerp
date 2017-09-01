<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataProjectSettlementChild extends Model
{
	use SoftDeletes;
    //
    protected $table = 'data_project_settlement_child';
    // protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $order;

}
