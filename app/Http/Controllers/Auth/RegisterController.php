<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use SmsManager;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/companyInfo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'verify_code' => '手机验证码错误',
            'mobile.unique' => '该手机号码已注册',
        ];
        $validator = Validator::make($data, [
            'mobile'     => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'verifyCode' => 'required|verify_code',
        ],$messages);

        if ($validator->fails()) {
            SmsManager::forgetState();
            return response()->json(['errors'=>$validator->errors()]);
        }

        return $validator;
    }

    // protected function validator(array $data)
    // {
    //     $validator = Validator::make($data, [
    //         'mobile'     => 'required|confirm_mobile_not_change|confirm_rule:mobile_required',
    //         'verifyCode' => 'required|verify_code',
    //     ]);
    //     if ($validator->fails()) {
    //        SmsManager::forgetState();
    //        return redirect()->back()->withErrors($validator);
    //     }
    // }


    protected function phoneValidator(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            'mobile'     => 'required',
            // 'verifyCode' => 'required|verify_code',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    // protected function create(array $data)
    // {
    //     dd($data);
    //     return User::create([
    //        // 'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => bcrypt($data['password']),
    //     ]);
    // }
    protected function create(array $data)
    {
        // $messages = [
        //     'validation.verify_code' => '手机验证码错误',
        //     'unique' => '该手机号码已注册',
        // ];
        // $validator = Validator::make($data, [
        //     'mobile'     => 'required|unique:users',
        //     'password' => 'required|min:6|confirmed',
        //     'verifyCode' => 'required|verify_code',
        // ],$messages);
        // if ($validator->fails()) {
        //     dd($validator->errors()->first('mobile'));
        //    SmsManager::forgetState();
        // //    return redirect('/')->withErrors($validator);
        // }
        return User::create([
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);
    }


    protected function createbyphone(array $data)
    {
        return User::create([
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        return response()->json(['status'=>'success','msg'=>'注册成功']);
    }

}
