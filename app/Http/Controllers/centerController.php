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

class centerController extends Controller
{
    public function getChildAccounts(){
        $rpermissions=Role::find(4)->permissions()->get();
        // dd($permissions);
        $id = Auth::id();
        if($id !== null){
            $childsData = DB::table('users')->where('id_parent', $id)->get();
            $postData = DB::table('user_info_accounts')->get();
            foreach ($childsData as $value) {
                $perids=get_all_permissionsid_by_uid($value->id);
                $value->perids=$perids;
                foreach ($postData as $key => $_value) {
                    if($value->id == $_value->id_user){
                        $value->post = $_value->post;
                    }
                }
            }
            //   dd($childsData);
            return view('user-center/accounts',['accountList' => $childsData,'permissions' => $rpermissions]);
        }else{
            return "请先登录";
        }
    }

    public function getCompanyInfo(Request $request){
        $userId = Auth::id();
        $companyData = DB::table('company')->where('user_id', $userId)->get();
        if(count($companyData) != 0){
            return view('user-center/company_info')->with(['companyData'=>$companyData[0]]);
        }else{
            return view('user-center/post_company_info');
        }
    }

    public function create(Request $request){
        $cuser = Auth::user();
        if (empty($cuser->id_parent)) {
            $userId = Auth::id();
            $userRole = DB::table('role_users')->where('user_id', $userId)->get();
            $userRole = $userRole[0]->role_id;
            $company= get_company_info_by_uid($userId);
            DB::transaction(function()use($userRole, $request ,$company){
                $user = new User;
                $user->id_parent = Auth::id();
                $user->name = $request->name;
                $user->mobile = $request->mobile;
                $user->password = bcrypt($request->password);
                $user->setRememberToken($token = Str::random(60));
                $user->company_id = $company->id;
                $user->save();
                // DB::table('user_info_accounts')->insert(['id_user'=>$user->id, 'post'=>$request->post]);
                DB::table('role_users')->insert(['role_id'=>$userRole, 'user_id'=>$user->id]);
                if (!empty($request->post)) {
                    $user->givePermissionTo($request->post);
                }
            });
    
            return Redirect::to('center/accounts');
        }

    }

    public function updateAccountInfo(Request $request){
        if (!empty($request->post)) {
            delete_all_permissions_by_uid($request->id);
            $user=User::find($request->id);
            $user->givePermissionTo($request->post);
        }
        $userId = Auth::id();
        $childs = DB::table('users')->where('id_parent', $userId)->get();
        foreach ($childs as $value) {
            if($value->id == $request->id){
                DB::transaction(function()use($value, $userId, $request){
                    DB::table('users')->where('id', $value->id)->update(['name'=>$request->name, 'mobile'=>$request->mobile, 'email'=>$request->email]);
                    // DB::table('user_info_accounts')->where('id_user', $request->id)->update(['post'=>$request->post]);
                });
            }
        }
        
        return Redirect::to('center/accounts');
    }

    public function delete(Request $request){
        $userId = Auth::id();
        $child = DB::table('users')->where('id', $request->id)->get();
        $child = $child[0];
        if($child->id_parent == $userId){
            DB::transaction(function()use($child){
                DB::table('users')->where('id',$child->id)->delete();
                DB::table('user_info_accounts')->where('id_user',$child->id)->delete();
                DB::table('role_users')->where('user_id',$child->id)->delete();
            });
        }
        return Redirect::to('center/accounts');
    }

    public function changePassword(Request $request){
        $account = DB::table('users')->where('id', Auth::id())->get();
        if(Auth::attempt(['email'=>$account[0]->email, 'password'=>$request->old_password], true)){
            DB::table('users')->where('id', Auth::id())->update(['password'=>bcrypt($request->new_password)]);
        }
        return Redirect::to('/center/account-safe');
    }
}
