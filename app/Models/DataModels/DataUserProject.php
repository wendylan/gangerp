<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataUserProject extends Model
{
	use SoftDeletes;
    //
    protected $table = 'data_user_project';
    protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $order;
	public function getProject($id){
		return $this::where('user_id','=',$id)->get();
	}
	
    
    public function hasManyOrders(){
		return $this->hasMany('App\DataModels\DataUserOrder','project_id','id');
	}

	public function belongsToUser(){
		return $this->belongsTo('App\User','user_id','id');
	}


}
