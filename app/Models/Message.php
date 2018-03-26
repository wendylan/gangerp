<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    protected $table = 'message';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo('App\User', 'from_uid','id')->select(['id','name']);
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse(date("Y-m-d H:i:s",$date))->diffForHumans();
    }
}
