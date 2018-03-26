<?php
namespace App\Http\Controllers\v1;
use Illuminate\Http\Request;
use DB;
use Hash;
use Auth;
use Redirect;
use App\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserInfoController extends BaseController{
	public function getCompanyInfo(Request $request){
        $userId = Auth::id();
        $companyData = DB::table('company')->where('user_id', $userId)->get();
        if(count($companyData) != 0){
            return $companyData->toArray();
        }else{
            return [];
        }
    }

    public function postCompanyInfo(Request $request){
        $userId = Auth::id();
        $userInfo = DB::table('company')->where('user_id', $userId)->get();
        $file = null;
        if($request->file('company_file_path')){
	        $image = $request->file('company_file_path');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $input['imagename']);
            $file = "..\..\public\images/".$input['imagename'];
        }
        if(count($userInfo) == 0){
            //账号信息数据格式
            $reviewInfo = array(
                'user_id'=>$userId, 'name'=>$request->company, 'company_contacts'=>$request->company_contacts,
                'province'=>$request->province, 'city'=>$request->city, 'county'=>$request->county, 'address'=>$request->address,
                'company_type'=>$request->company_type, 'company_attr'=>$request->company_attr, 'is_listed'=>$request->is_listed,
                'company_number'=>$request->company_number, 'register_money'=>$request->register_money,  'company_file_path'=>$file,
                'company_boss'=>$request->company_boss, 'company_tel'=>$request->company_tel, 'idcard_number'=>$request->idcard_number
            );
            // 数据插入表 : 账号审核信息
            DB::table('company')->insertGetId($reviewInfo);

        }else{
            //账号信息数据格式
            if($request->company_file_path != null){
                $reviewInfo = array(
                    'user_id'=>$userId, 'name'=>$request->company, 'company_contacts'=>$request->company_contacts,
                    'province'=>$request->province, 'city'=>$request->city, 'county'=>$request->county, 'address'=>$request->address,
                    'company_type'=>$request->company_type, 'company_attr'=>$request->company_attr, 'is_listed'=>$request->is_listed,
                    'company_number'=>$request->company_number, 'register_money'=>$request->register_money, 'company_file_path'=>$file,
                    'company_boss'=>$request->company_boss, 'company_tel'=>$request->company_tel, 'idcard_number'=>$request->idcard_number
                );
            }else{

                $reviewInfo = array(
                    'user_id'=>$userId, 'name'=>$request->company, 'company_contacts'=>$request->company_contacts,
                    'province'=>$request->province, 'city'=>$request->city, 'county'=>$request->county, 'address'=>$request->address,
                    'company_type'=>$request->company_type, 'company_attr'=>$request->company_attr, 'is_listed'=>$request->is_listed,
                    'company_number'=>$request->company_number, 'register_money'=>$request->register_money,
                    'company_boss'=>$request->company_boss, 'company_tel'=>$request->company_tel, 'idcard_number'=>$request->idcard_number
                );
            }
            // 数据表更新 : 账号审核信息
            DB::table('company')->where('user_id', $userId)->update($reviewInfo);
        }
        return $this->responseBuild('修改成功');
    }
    public function getUserInfo(Request $req){
        $user = Auth::user();
        $user->permissions = Auth::user()->permissions;
        $user->roles = Auth::user()->roles;
        return ['user'=>Auth::user()];
    }
    public function modifyPassword(Request $request){
        $account = DB::table('users')->where('id', Auth::id())->get();
        if(Auth::attempt(['email'=>$account[0]->email, 'password'=>$request->old_password], true)){
            DB::table('users')->where('id', Auth::id())->update(['password'=>bcrypt($request->new_password)]);
        }else{
            $this->response->error('原密码错误',500);
        }
        return $this->responseBuild('修改成功');
    }
    public function testPostFile(Request $req){
        dd($req->all());
        return [];
    }

}


?>
