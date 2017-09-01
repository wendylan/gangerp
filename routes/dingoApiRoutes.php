<?php

use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Controllers\v1\DataProjectController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',['middleware' => ['api' , 'isLogin'],'namespace'=>'App\Http\Controllers\v1'], function ($api) {
//     // $api->get('/user', function (Request $request) {
//     //     return  $this->response->error('This is an error.', 404);
//     // });

	$api->get('/allspecs', 'DatasController@allspecs')->middleware('apitest:编辑报价');
    $api->get('/getAllspecsAndNotice', 'DatasController@getAllspecsAndNotice')->middleware('apitest:编辑报价');
    $api->get('/getDataFromSetting', 'DatasController@getDataFromSetting')->middleware('apitest:编辑报价');
    $api->get('/getMarketData', 'DatasController@getMarketData')->middleware('apitest:编辑报价');
    $api->post('/editMarketData', 'DatasController@editMarketData')->middleware('apitest:编辑报价');
    $api->post('/createMarketPrice', 'DatasController@createMarketPrice')->middleware('apitest:编辑报价');
    $api->get('/createMarketRecord', 'DatasController@createMarketRecord')->middleware('apitest:新增报价');
    $api->get('/getLastMarketPrice', 'DatasController@getLastMarketPrice')->middleware('apitest:编辑报价');
    $api->get('/delMarketDatas', 'DatasController@delMarketDatas')->middleware('apitest:删除报价');
    $api->get('/reportMarketData', 'DatasController@reportMarketData')->middleware('apitest:发布报价');
    $api->get('/getMarketDatasAtDate', 'DatasController@getMarketDatasAtDate')->middleware('apitest:编辑报价');
    $api->get('/getPrveMarketData', 'DatasController@createPrveMarketData')->middleware('apitest:编辑报价');
    $api->post('/fillMarketPrice', 'DatasController@fillMarketPrice')->middleware('apitest:编辑报价');

        // 报价来源模块
        $api->post('/createPriceSource', 'DatasController@createPriceSource')->middleware('apitest:编辑报价');
        $api->post('/editPriceSource', 'DatasController@editPriceSource')->middleware('apitest:编辑报价');
        $api->post('/delPriceSource', 'DatasController@delPriceSource')->middleware('apitest:编辑报价');
        // 仓库模块
        $api->post('/createWarehouse', 'DatasController@createWarehouse')->middleware('apitest:编辑报价');
        $api->post('/editWarehouse', 'DatasController@editWarehouse')->middleware('apitest:编辑报价');
        $api->post('/delWarehouse', 'DatasController@delWarehouse')->middleware('apitest:编辑报价');
        // 付款选项模块
        $api->post('/createPaymentKind', 'DatasController@createPaymentKind')->middleware('apitest:编辑报价');
        $api->post('/editPaymentKind', 'DatasController@editPaymentKind')->middleware('apitest:编辑报价');
        $api->post('/delPaymentKind', 'DatasController@delPaymentKind')->middleware('apitest:编辑报价');

    // 运费价格模块
    $api->post('/createFreightPrice', 'DatasController@createFreightPrice')->middleware('apitest:运费管理');
    $api->get('/getFreightPrice', 'DatasController@getFreightPrice')->middleware('apitest:运费管理');
    $api->post('/editFreightPrice', 'DatasController@editFreightPrice')->middleware('apitest:运费管理');
    $api->post('/delFreightPrice', 'DatasController@delFreightPrice')->middleware('apitest:运费管理');

    // 网价数据的接口
    $api->get('/initForGetWebPrice', 'GetSteelDataController@initForGetWebPrice');
    $api->get('/getWebPriceDate', 'GetSteelDataController@getWebPriceDate');
    $api->get('/checkWebPriceData', 'GetSteelDataController@checkWebPriceData');
    $api->post('/saveWebPriceData', 'GetSteelDataController@saveWebPriceData');
    $api->post('/updateWebPriceData', 'GetSteelDataController@updateWebPriceData');



    // 风险提示设置
    $api->get('/getNoticeDatas', 'DatasController@getNoticeDatas')->middleware('apitest:前台浮动设置');
    $api->post('/createPriceNotice', 'DatasController@createPriceNotice')->middleware('apitest:前台浮动设置');
    $api->post('/editNoticeDatas', 'DatasController@editNoticeDatas')->middleware('apitest:前台浮动设置');
    $api->post('/deleteNoticeDatas', 'DatasController@deleteNoticeDatas')->middleware('apitest:前台浮动设置');


// 钢材价格页面
    $api->get('/getSteelMarketList', 'DatasController@getSteelMarketList');
    $api->get('/getSteelMarketDatas', 'DatasController@getSteelMarketDatas');
    $api->get('/searchTransportForCity', 'DatasController@searchTransportForCity');

	// 项目报价页面
    $api->get('/getInitForSteelDeal', 'DatasController@getInitForSteelDeal');


// 资源推荐页面
    $api->get('/getRecommendingResource', 'DatasController@getRecommendingResource');
    $api->get('/brandsDiff', 'DatasController@brandsDiff');

// 运费
    $api->get('/getAllFreightsData', 'freightsDataController@getAllFreightsData');
    $api->get('/seachFreightRecord', 'freightsDataController@seachFreightRecord');

//历史数据
    $api->post('/seachHistoryPrice', 'historyDataController@seachHistoryPrice');
        $api->post('/getProductsData', 'historyDataController@getProductsData');
        $api->get('/getFactorys', 'historyDataController@getFactorys');
// other
    $api->get('/getRecordFromDate', 'DatasController@getRecordFromDate');

// public
    //
    $api->get('/getAllbrands', 'DatasController@getAllbrands');
    $api->get('/getAllHasbrands', 'DatasController@getAllHasbrands');

    // 后台数据管理页面列表获取
    $api->get('/listData', 'DatasController@getListData');

    // 更新数据平均数
    $api->get('/updateBrandDataMean', 'DatasController@updateBrandDataMean');

    //定价规则
    $api->get('/marketDataHandle', 'MarketDataHandleController@marketDataHandle');
    $api->get('/getRule', 'MarketDataHandleController@getRule')->middleware('apitest:定价规则');
    $api->get('/getRuleData', 'MarketDataHandleController@getRuleData')->middleware('apitest:定价规则');

    //Test
    $api->get('/test_path', 'DatasController@showTable');
    //获取钢材信息所有数据
    $api->get('/getSteelInfo', 'GetSteelDataController@getSteelInfo');
    $api->get('/getSteelBrandSource', 'GetSteelDataController@getSteelBrandSource');

    //订单
    $api->get('/getUserOrder', 'UserOrderController@getUserOrder');
    $api->get('/getUserProject', 'UserOrderController@getUserProject');
    $api->get('/getOrder', 'UserOrderController@getOrder');
    $api->post('/saveOrder', 'UserOrderController@saveOrder');
    $api->post('/updateOrder', 'UserOrderController@updateOrder');
    $api->post('/cancelOrder', 'UserOrderController@cancelOrder');
    $api->post('/finishOrder', 'UserOrderController@finishOrder');
    $api->post('/resendOrder', 'UserOrderController@resendOrder');
    $api->post('/deleteOrder', 'UserOrderController@deleteOrder');
    //api响应测试
    // $api->get('/responseTest', 'freightsDataController@responseTest');

    // 新版本 报价平台 功能路由
    $api->get('/getSoptPriceByDate', 'SoptPricePageController@getSoptPriceByDate');
    $api->get('/getSoptPrice', 'SoptPricePageController@getSoptPrice');
	$api->get('/getOrderPageDefault', 'UserCenterPageController@init');

    $api->get('/getFreightByCity', 'freightsDataController@getFreightByCity');

    $api->get('/getWebPriceByDate', 'GetSteelDataController@getWebPriceByDate');

    $api->get('/getBrandSpec', 'PurchasePageController@getBrandSpec');


    $api->get('/getPriceTimesByDate', 'WebPricePageController@getPriceTimesByDate');
    $api->post('/addProjectDatas', 'UserDealPageController@addProject');
    $api->get('/getMainDatasByDate', 'MainPricePageController@getMainDatasByDate');
    $api->post('/editProjectDatas', 'UserCenterPageController@editProject');
	$api->get('/delProjectDatas', 'UserCenterPageController@delProject');
    $api->get('/getSettlementInfo', 'UserDealPageController@getSettlementInfo');
	$api->get('/getPriceDatasByDate', 'UserDealPageController@getPriceDatasByDate');
	$api->get('/changesProjectContact', 'UserCenterPageController@changesProjectContact');
	$api->get('/cancelProjectContact', 'UserCenterPageController@cancelProjectContact');
	$api->get('/getUserProjectDatas', function(){
		$projects = (new DataProjectController)->getUserProject() ? (new DataProjectController)->getUserProject() : [];
		$companys = Company::select('user_id', 'name')->get()->toArray();
		return array('data'=>['projects'=>$projects, 'companys'=>$companys],'message'=>'success','status_code'=>200);
	});

    $api->get('/getAllProduct', 'ResourcesPageController@getAllProduct');

    $api->get('/getResourceInfo', 'ResourcesPageController@getResourceInfo');
    $api->get('/getPriceGroupByBrand', 'ResourcesPageController@getPriceGroupByBrand');
    $api->get('/getResourceAnalysis', 'ResourcesPageController@getResourceAnalysis');
});
