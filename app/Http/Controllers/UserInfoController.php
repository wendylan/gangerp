<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Hash;
use Auth;
use Redirect;
use App\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserInfoController extends Controller{
	public function getCompanyInfo(Request $request){
        $userId = Auth::id();
        $companyData = DB::table('company')->where('user_id', $userId)->get();
        if(count($companyData) != 0){
            return view('SteelData/userInfo')->with(['companyData'=>$companyData[0]]);
        }else{
            return view('SteelData/postUserInfo');
        }
    }

    public function  handle(){
    	
    }
}


?>
