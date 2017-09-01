<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
	use \Venturecraft\Revisionable\RevisionableTrait;
    protected $table = 'quote_prices';
	protected $primaryKey = 'id';
	// public $timestamps = false;
	 protected $guarded = ['id'];
	//protected $fillable = ['bid','who','quotes','base_type','up_down','net_price','up_price','s_price','d_price','m_price','u_price','t_price','mark'];
	// protected $hidden = [];
    // protected $dates = [];
	public $timestamps = true;


	protected $casts = [
        'quotes' => 'array',
		//'companys' => 'array'
    ];
}
