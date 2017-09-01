<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataProjectSettlement extends Model
{
	// use SoftDeletes;
    //
    protected $table = 'data_project_settlement';
    // protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $order;

}
