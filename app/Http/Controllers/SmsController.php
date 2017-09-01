<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use phpSms;


class SmsController extends BaseController
{

    function send(){
                    // 接收人手机号
            $to = '13560126399';
            // 短信模版
            $templates = [
                'YunPian' => '1595764',
                //'SubMail'    => 'your_temp_id'
            ];
            // 模版数据
            $tempData = [
                'code' => '87392',
                'minutes' => '5'
            ];
            // 短信内容
            $content = '【签名】这是短信内容...';

            // 只希望使用模板方式发送短信,可以不设置content(如:云通讯、Submail、Ucpaas)
            //PhpSms::make()->to($to)->template($templates)->data($tempData)->send();

            // // 只希望使用内容方式放送,可以不设置模板id和模板data(如:云片、luosimao)
             PhpSms::make()->to($to)->content($content)->send();

            // // 同时确保能通过模板和内容方式发送,这样做的好处是,可以兼顾到各种类型服务商
            // PhpSms::make()->to($to)
            //      ->template($templates)
            //      ->data($tempData)
            //      ->content($content)
            //      ->send();

                }

}
