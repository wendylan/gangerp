<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

class SqlRecord
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    // 设置url请求对应操作的table
    public function setTableList(){
        return [
                // 主要Api
                    ['url'=>'api/createMarketRecord', 'table'=>'data_market_datas'],
                    ['url'=>'api/createMarketPrice', 'table'=>'data_market_datas_child'],
                    ['url'=>'api/editMarketData', 'table'=>'data_market_datas_child'],
                    ['url'=>'api/delMarketDatas', 'table'=>'data_market_datas'],
                    ['url'=>'api/reportMarketData', 'table'=>'data_market_datas'],
                    ['url'=>'api/getPrveMarketData', 'table'=>'data_market_datas'],
                    ['url'=>'api/editFreightPrice', 'table'=>'data_transport'],

                // 次要Api
                    ['url'=>'api/createPriceSource', 'table'=>'data_price_source'],
                    ['url'=>'api/editPriceSource', 'table'=>'data_price_source'],
                    ['url'=>'api/delPriceSource', 'table'=>'data_price_source'],

                    ['url'=>'api/createWarehouse', 'table'=>'data_warehouse'],
                    ['url'=>'api/editWarehouse', 'table'=>'data_warehouse'],
                    ['url'=>'api/delWarehouse', 'table'=>'data_warehouse'],
               ];
    }

    // 主要过程
    public function handle($request, Closure $next)
    {
        $reqUrl = $request->url();
        $userInfo = $request->user();
        $tableName = $this->hasUrl($reqUrl);
        // 是否在记录列表内
        if($tableName){
            // 操作的数据是否单一或集合
            $reqMainData = $this->getArrayValue($request->all());
            $reqMainData==false ? $hasId=$request->input('id') : $hasId = array_key_exists('id', $reqMainData[0]);

            if($reqMainData){
                // 是否存在ID , 存在为编辑/删除, 不存在为新增
                if($hasId){
                    $this->recording($reqUrl, $userInfo['attributes']['email'], $this->getListIds($reqMainData), $tableName);
                }else{
                    $lastId = $this->getTableLastId($tableName);
                    $idArr = [];
                    foreach ($reqMainData as $key => $value) {
                        $idArr[] = $lastId++;
                    }
                    $this->recording($reqUrl, $userInfo['attributes']['email'], $idArr, $tableName);
                }
            }else{
                if($hasId){
                    $this->recording($reqUrl, $userInfo['attributes']['email'], (int)$request->input('id'), $tableName);
                }else{
                    $this->recording($reqUrl, $userInfo['attributes']['email'], $this->getTableLastId($tableName), $tableName);
                }
            }
        }

        return $next($request);

    }

    // 将记录插入数据库
    public function recording($url, $email, $idGroup, $tableName){
        DB::table('data_history_record')->insert([
            'url' => $url,
            'user_email' => $email,
            'target_id' => json_encode($idGroup),
            'target_table' => $tableName
        ]);
    }

    // 获取索引自增量
    public function getTableLastId($tableName){
        return DB::select("SHOW TABLE STATUS LIKE '".$tableName."'")[0]->Auto_increment;
    }

    // 判断$url是否在记录列表url中
    public function hasUrl($url){
        $tableList = $this->setTableList();
        $result = false;
        foreach ($tableList as $index => $value) {
            if(strstr($url, $value['url'])){
                $result = $value['table'];
            }
        }
        return $result;
    }

    // 获取数组集合中类型为数组的值
    public function getArrayValue($reqData){
        $result = false;
        foreach ($reqData as $key => $value) {
            if(gettype($value) == 'array'){
                $result = $value;
                break;
            }
        }
        return $result;
    }

    // 获取列表中所有key为id的字段, 返回一个新数组
    public function getListIds($arr){
        $result = [];
        foreach ($arr as $key => $value) {
            $result[] = (int)$value['id'];
        }
        return $result;
    }
    
}
