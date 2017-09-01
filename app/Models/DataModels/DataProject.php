<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;
use Auth;
use App\Models\DataModels\DataProject;
use App\Models\DataModels\DataProjectInfo;

class DataProject extends Model
{
	use SoftDeletes;
    //
    protected $table = 'data_project';
    protected $primaryKey = 'project_id';
    // protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $order;

}
