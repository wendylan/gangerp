<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\DataModels\DataMarketDatasChild;

class SteelAmountPageController extends DataProjectController{

    public function index(){
        $todayDate = date('Y-m-d', gettimeofday()['sec']);
        // $result = DataMarketDatasChild::where('created_at', '>' , $todayDate.' 00:00:00')
        //     ->where('created_at', '<' , $todayDate.' 23:59:59')
        //     ->where('inventory', '无货')
        //     ->get();
        $result = DataMarketDatasChild::where('created_at', '>' , '2017-05-05'.' 00:00:00')
            ->where('created_at', '<' , '2017-09-05'.' 23:59:59')
            ->where('inventory', '无货')
            ->get();
        $projects = parent::getUserProject();
        return view('SteelData/SteelProductAmount', ['resultDatas' => ['projects'=>$projects, 'productAmount'=>$result]]);
    }

}
