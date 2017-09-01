<?php

namespace App\Models;

use Hootlex\Moderation\Moderatable;
use Illuminate\Database\Eloquent\Model;


class Bid extends Model
{
	// use Moderatable;
	use \Venturecraft\Revisionable\RevisionableTrait;
    protected $table = 'bids';
	protected $primaryKey = 'id';
	// public $timestamps = false;
	// protected $guarded = ['id'];
	 protected $fillable = ['pid','name','uid','brands','type','mtype','amount','mtype','settlement','paytype','quote_request','deposit','deposit_type','deposit_account','deposit_bank_name','tender_deadline','deposit_return','tender_price','tender_add','tender_open_sale','stage','status','bid_deadline','bod','delivery_day','quote_list','remark','bid_to','want_price','up_dwon','sup_down','moderated_by','moderated_at','review_agree','review_reason','decision_agree','decision_reason','bid_to'];
	// protected $hidden = [];
    // protected $dates = [];
	public $timestamps = true;


	protected $casts = [
		'brands' => 'array',
        'quote_list' => 'array',
		'quote_request' => 'array',
		'companys' => 'array',
		'want_price' => 'array',
		'sup_down' => 'array'
    ];
}
