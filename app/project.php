<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    protected $table = 'project';
	protected $primaryKey = 'id';
	// public $timestamps = false;
	// protected $guarded = ['id'];
	 protected $fillable = ['name','province','city','area','add','brands','mtype','settlement','paytype','quote_request'];
	// protected $hidden = [];
    // protected $dates = [];
	public $timestamps = true;
	
}
