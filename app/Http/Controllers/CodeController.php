<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
// use Session;
use SmsManager;
class CodeController extends Controller
{

    public $request;

    public function __construct()
    {

        // $this->middleware('CheckLogin')->except('regsms');
        $this->middleware('auth', ['except' => ['captcha','regsms']]);
        // $this->request=Request $request;
    }

    public function captcha(Request $request)
    {
        $phraseBuilder = new PhraseBuilder(4, '0123456789');
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build(150,40);
        $phrase = $builder->getPhrase();
        session()->flash('66regcaptcha', $phrase);

        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    public function regsms(Request $request){
        $this->request=$request;
        if ($request->isMethod('post')) {

            $validator = \Validator::make($request->all(), [
                'postcaptcha' => 'required|max:4',
            ]);
            $validator->after(function($validator) {
                $inrequest=$this->request;
                if (!$this->validate_captcha($inrequest)) {
                    $validator->errors()->add('postcaptcha', '验证码错误');
                }else{
                    $result = SmsManager::requestVerifySms();
                }
            });

            if ($validator->fails()) {
                return response()->json('验证码错误,请重新输入',422);
            }else{
                return response()->json(['status'=>'success','msg'=>'手机验证码发送成功']);
            }
            
        }

    }

    public function validate_captcha(Request $request){
        $value = $request->session()->get('66regcaptcha');
        $scaptcha= $request->input('postcaptcha');
        return $retVal = ($value==$scaptcha) ? 1 : 0 ;
    }

}