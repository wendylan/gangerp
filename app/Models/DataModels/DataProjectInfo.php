<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataProjectInfo extends Model
{
	use SoftDeletes;
    //
    protected $table = 'data_project_info';
    protected $primaryKey = 'project_info_id';
    // protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $order;

}
