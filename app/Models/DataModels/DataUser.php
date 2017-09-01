<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class DataUser extends Model
{
    // use SoftDeletes;
    protected $table = 'users';
    // protected $dates=['deleted_at'];
    protected $guarded = [];
    public function hasOneUserInfo()
	{
     	return $this->hasOne('user_info', 'user_id', 'id');
	}
    
}

