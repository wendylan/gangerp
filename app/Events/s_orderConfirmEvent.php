<?php 
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
// use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class s_orderConfirmEvent
{
    // use Dispatchable, InteractsWithSockets, SerializesModels;
    use InteractsWithSockets, SerializesModels;
    // public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public function __construct($toUid,$msg='确认订单')
     {
         $model = new Message();
         $model->to_uid = $toUid;
         $model->content = $msg;
         $model->save();
     }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    //如果要明确广播什么数据，用下列方法，否则就会将当前类的所有公开属性广播出去
    public function broadcastWith()
	{
	    return ['user_id' => $this->user_id];
	}
}

?>