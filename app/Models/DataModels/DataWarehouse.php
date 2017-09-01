<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataWarehouse extends Model
{
	use SoftDeletes;
    //
    protected $table = 'data_warehouse';
    protected $dates = ['deleted_at'];
    protected $guarded = [];

}
