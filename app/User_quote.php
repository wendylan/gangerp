<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_quote extends Model
{
    protected $table = 'user_quote';
	protected $primaryKey = 'id';
	// public $timestamps = false;
	// protected $guarded = ['id'];
	 protected $fillable = ['bid','uid','qstatus','quote'];
	// protected $hidden = [];
    // protected $dates = [];
	public $timestamps = true;


	protected $casts = [
        'quote' => 'array',
    ];
}
