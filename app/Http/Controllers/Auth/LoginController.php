<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

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
        $this->middleware('guest', ['except' => 'logout']);
    }


    public function login(Request $request)
    {

       // dd($request);
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        // dd($credentials);
        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            // dd($this);
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if (! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }


    protected function validateLogin(Request $request)
    {

        $this->validate($request, [
           // $this->username() => 'required', 'password' => 'required',
            'account' => 'required', 'password' => 'required',
        ]);
    }


    protected function credentials(Request $request)
    {
        
        $account=$request->input('account');
        $isemail=filter_var($account, FILTER_VALIDATE_EMAIL);
        $temp_credentials=$request->only($this->username($isemail), 'password');
        $temp_credentials[$this->username($isemail)]=$account;
        return $temp_credentials;
        //return $request->only($this->username($isemail), 'password');
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username($isemail=1)
    {
        if(empty($isemail)){
            return 'mobile';
        }else{
            return 'email';
        }

    }


    protected function authenticated(Request $request, $user)
    {   
        if ($user->hasRole('bidder')) {
            return redirect('/bidder/my');
        }else if ($user->hasRole('次终端用户')) {
            return redirect($this->rolePermissionRedirect( $user, '次终端用户' ));
        }else if ($user->hasRole('终端用户')) {
            return redirect($this->rolePermissionRedirect( $user, '终端用户' ));
        }else if ($user->hasRole('tenderee')) {
            return redirect('/tenderee/my');
        }else if($user->hasRole('admin')){
            return redirect('/admin');
        }else if($user->hasRole('后台数据录入')){
            return redirect('admin/steel_brands');
        }else if($user->hasRole('前台数据管理员')){
            return redirect('dataManage');
        }else if($user->roles->isEmpty()){
            return redirect('signCompany');
        }else {
            return redirect('/');
        }
    }


    protected function rolePermissionRedirect($user,$role_name){
        $permissions = $user->permissions;
        $url_info = config('user_permission_redirect_map.redirectMap');
        foreach ($url_info as $role_key => $role) {
            if($role['role'] == $role_name){
                foreach ($role['permissions_and_router'] as $map_key => $map) {
                    foreach ($permissions as $key => $value) {
                        if($value->name == $map['name']){
                            return $map['url'];
                        }
                    }
                }
            }
        }
        return $this->redirectTo;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $previous_session = Auth::User()->session_id;
        if ($previous_session) {
            \Session::getHandler()->destroy($previous_session);
        }
    
        Auth::user()->session_id = \Session::getId();
        Auth::user()->save();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }


}
