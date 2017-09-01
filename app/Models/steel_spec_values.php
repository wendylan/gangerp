<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class steel_spec_values extends Model
{
    protected $table = 'steel_products_spec_value';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['spec_id','name','code','sort'];
    protected $visible = ['id','spec_id','name','code','sort'];
    // protected $hidden = [];
    // protected $dates = [];
    public $timestamps = true;




    public function specs()
    {
        return $this->belongsTo('App\Models\SteelSpec', 'spec_id');
    }



}
