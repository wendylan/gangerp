<?php
namespace App\Handlers;

/**
 * Created by PhpStorm.
 * User: younger
 * Date: 17/3/7
 * Time: 上午10:42
 */
use App\Models\Message;
use Illuminate\Support\Facades\Redis;

class SwooleHandler
{
    public function onOpen($ws, $request)
    {
        $uid = $request->get['uid'];
        echo "client-{$request->fd} is opened\n";
        Redis::hSet('USERS', $uid, $request->fd);
        var_dump(Redis::hGet('USERS', 9));
    }

    public function onMessage($ws, $frame)
    {
        $uid=$frame->data;
        $fd = Redis::hGet('USERS', $uid);
        echo "client-{$fd} is send\n";
        $num=Message::query()->where('to_uid',$uid)->count();
        $ws->push($fd, $num);
    }

    public function onClose($ws, $fd)
    {
        echo "client-{$fd} is closed\n";
        $all = Redis::hGetAll('USERS');
        foreach ($all as $key => $val) {
            if ($fd == Redis::hGet('USERS', $key)) {
                Redis::hDel('USERS', $key);
                echo "del {$key}";
            }
        }
    }

}