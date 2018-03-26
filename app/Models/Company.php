<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Company extends Model
{


     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

	protected $table = 'company';
	protected $primaryKey = 'id';
	// protected $guarded = ['id'];
	protected $fillable = ['name','user_id','province'];
	// protected $hidden = [];
    // protected $dates = [];
	public $timestamps = true;

	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

	public function getAgentCompanys(){
		$roles = DB::table('roles')->where('name', '次终端用户')->get()->toArray()[0];
		$result = Company::all()->filter(function($item) use($roles){
			$roleInfo = DB::table('role_users')
				->where('user_id', $item['user_id'])
				->select('role_id')
				->get()->toArray();

			if(strpos(json_encode($roleInfo), (':'.(String)$roles->id).'}')){
				return $item;
			}
		});
		return array_values($result->toArray());
	}

	public static function getUserBussinessInfo($id){
		return Company::where('user_id',$id)->get();
	}
	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	/*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
