<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\User;
use Redirect;
use Hash;
use Auth;
use DB;

class userController extends Controller
{
    public function reviewUser(Request $request){

        $userId = Auth::id();
        $userInfo = DB::table('company')->where('user_id', $userId)->get();

        if(count($userInfo) == 0){
            //账号信息数据格式
            $reviewInfo = array(
                'user_id'=>$userId, 'name'=>$request->company, 
                'province'=>$request->province, 'city'=>$request->city, 'county'=>$request->county, 'address'=>$request->address,
                'company_type'=>$request->company_type, 'company_attr'=>$request->company_attr, 'is_listed'=>$request->is_listed,
                'company_number'=>$request->company_number, 'register_money'=>$request->register_money,  'company_file_path'=>$request->file('company_file_path')->store('..\..\public\images'),
                'company_boss'=>$request->company_boss, 'company_tel'=>$request->company_tel, 'idcard_number'=>$request->idcard_number
            );
            // 数据插入表 : 账号审核信息
            DB::table('company')->insertGetId($reviewInfo);
            return view("temp")->with(["text"=>"提交成功"]);
        }else{
            //账号信息数据格式
            if($request->company_file_path != null){
                $reviewInfo = array(
                    'user_id'=>$userId, 'name'=>$request->company, 
                    'province'=>$request->province, 'city'=>$request->city, 'county'=>$request->county, 'address'=>$request->address,
                    'company_type'=>$request->company_type, 'company_attr'=>$request->company_attr, 'is_listed'=>$request->is_listed,
                    'company_number'=>$request->company_number, 'register_money'=>$request->register_money, 'company_file_path'=>$request->file('company_file_path')->store('..\..\public\images'),
                    'company_boss'=>$request->company_boss, 'company_tel'=>$request->company_tel, 'idcard_number'=>$request->idcard_number
                );
            }else{
                $reviewInfo = array(
                    'user_id'=>$userId, 'name'=>$request->company, 
                    'province'=>$request->province, 'city'=>$request->city, 'county'=>$request->county, 'address'=>$request->address,
                    'company_type'=>$request->company_type, 'company_attr'=>$request->company_attr, 'is_listed'=>$request->is_listed,
                    'company_number'=>$request->company_number, 'register_money'=>$request->register_money,
                    'company_boss'=>$request->company_boss, 'company_tel'=>$request->company_tel, 'idcard_number'=>$request->idcard_number
                );
            }
            // 数据表更新 : 账号审核信息
            DB::table('company')->where('user_id', $userId)->update($reviewInfo);
            return view("temp")->with(["text"=>"修改成功"]);
        }
    }

}
