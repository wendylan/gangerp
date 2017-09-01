<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use DB;
use Auth;
use App\Events\SqlRecord;
use App\Models\DataModels\DataMarketDatasChild;
use App\Models\DataModels\DataMarketDatas;
use App\Models\DataModels\DataTransport;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
        DataMarketDatasChild::created(function($data){
            DB::table('data_user_record')->insert([ 'user_name'=>Auth::user()['email'], 'action'=>'create', 'table'=>'data_market_datas_child', 'data_id'=>$data['attributes']['id'] ]);
        });

        DataMarketDatasChild::updated(function($data){
            DB::table('data_user_record')->insert([ 'user_name'=>Auth::user()['email'], 'action'=>'update', 'table'=>'data_market_datas_child', 'data_id'=>$data['attributes']['id'] ]);
        });

        DataMarketDatasChild::deleted(function($data){
            DB::table('data_user_record')->insert([ 'user_name'=>Auth::user()['email'], 'action'=>'delete', 'table'=>'data_market_datas_child', 'data_id'=>$data['attributes']['id'] ]);
        });

        DataMarketDatas::created(function($data){
            DB::table('data_user_record')->insert([ 'user_name'=>Auth::user()['email'], 'action'=>'create', 'table'=>'data_market_datas', 'data_id'=>$data['attributes']['id'] ]);
        });

        DataMarketDatas::updated(function($data){
            DB::table('data_user_record')->insert([ 'user_name'=>Auth::user()['email'], 'action'=>'update', 'table'=>'data_market_datas', 'data_id'=>$data['attributes']['id'] ]);
        });

        DataMarketDatas::deleted(function($data){
            DB::table('data_user_record')->insert([ 'user_name'=>Auth::user()['email'], 'action'=>'delete', 'table'=>'data_market_datas', 'data_id'=>$data['attributes']['id'] ]);
        });

        DataTransport::updated(function($data){
            DB::table('data_user_record')->insert([ 'user_name'=>Auth::user()['email'], 'action'=>'update', 'table'=>'data_transport', 'data_id'=>$data['attributes']['id'] ]);
        });

        DataTransport::deleted(function($data){
            DB::table('data_user_record')->insert([ 'user_name'=>Auth::user()['email'], 'action'=>'delete', 'table'=>'data_transport', 'data_id'=>$data['attributes']['id'] ]);
        });

    }
}
