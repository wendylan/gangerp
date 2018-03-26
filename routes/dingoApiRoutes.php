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
        $api->get('/getAllPriceSource', 'PriceSourceController@getAllPriceSource');
        $api->post('/delPriceSourceName', 'PriceSourceController@delPriceSourceName');
        $api->post('/editPriceSourceName', 'PriceSourceController@editPriceSourceName');
        $api->post('/addPricSourceName', 'PriceSourceController@addPricSourceName');
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
    $api->get('/getInitDatasByMarket', 'DatasController@getInitDatasByMarket');

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
    $api->get('/getUserProject', 'DataProjectController@getUserProject');
    $api->get('/getPurcharOrder', 'UserOrderController@getPurcharOrder');
    $api->get('/getUserOrder', 'UserOrderController@getUserOrder');
    $api->get('/getOrder', 'UserOrderController@getOrder');
    $api->post('/saveOrder', 'UserOrderController@saveOrder');
    $api->post('/serviceSaveOrder', 'UserOrderController@serviceSaveOrder');
    $api->post('/savePlanOrder', 'UserOrderController@savePlanOrder');
    $api->post('/updateOrder', 'UserOrderController@updateOrder');
    $api->post('/memoryOrder', 'UserOrderController@memoryOrder');
    $api->post('/cancelOrder', 'UserOrderController@cancelOrder');
    $api->post('/finishOrder', 'UserOrderController@finishOrder');
    $api->post('/sendForReceived', 'UserOrderController@sendForReceived');
    $api->post('/confirmReceived', 'UserOrderController@confirmReceived');
    $api->post('/resendOrder', 'UserOrderController@resendOrder');
    $api->post('/sendForPurchar', 'UserOrderController@sendForPurchar');
    $api->post('/orderPurcharSendService', 'UserOrderController@orderPurcharSendService');
    $api->post('/orderPurcharSave', 'UserOrderController@orderPurcharSave');
    $api->post('/deleteOrder', 'UserOrderController@deleteOrder');
    // 订单收货时间
    $api->get('/receivedTime', 'UserOrderController@receivedTime');
    $api->get('/getOrderHistoryInfo', 'UserOrderController@getOrderHistoryInfo');
    $api->post('/getUserCompanyInfo', 'UserOrderController@getUserCompanyInfo');
		//导出指定订单excle
	$api->get('/exportExcel/{dateRange}', 'UserOrderController@exportExcel');

    // 物流信息
    $api->get('/getCarInfo', 'UserCarInfoController@getCarInfo');
    $api->post('/addCarInfo', 'UserCarInfoController@addCarInfo');
    $api->post('/editCarInfo', 'UserCarInfoController@editCarInfo');
    $api->post('/deleteCarInfo', 'UserCarInfoController@deleteCarInfo');

	// 品牌详情
    $api->get('/getAllBrandSupplier', 'BrandInfoController@getAllBrandSupplier');
    $api->get('/getBrandInfo', 'BrandInfoController@getBrandInfo');
    $api->post('/addBrandInfo', 'BrandInfoController@addBrandInfo');
    $api->post('/editBrandInfo', 'BrandInfoController@editBrandInfo');
    $api->post('/delBrandInfo', 'BrandInfoController@delBrandInfo');

    //次中端买买买
    $api->post('/saveStOrder', 'UserOrderController@saveStOrder');
    $api->get('/getStOrder', 'UserOrderController@getStOrder');
    $api->get('/getUserStOrder', 'UserOrderController@getUserStOrder');
    //api响应测试
    // $api->get('/responseTest', 'freightsDataController@responseTest');
    //公司信息
    $api->get('/getCompanyInfo', 'UserInfoController@getCompanyInfo');
    $api->post('/postCompanyInfo', 'UserInfoController@postCompanyInfo');

    // 新版本 报价平台 功能路由
    $api->get('/getSoptPriceByDate', 'SoptPricePageController@getSoptPriceByDate');
    $api->get('/getSoptPrice', 'SoptPricePageController@getSoptPrice');
    $api->get('/getPurchaseSpotPrice', 'SoptPricePageController@getPurchaseSpotPrice');
    $api->get('/getAllSoptPrice', 'SoptPricePageController@getAllSoptPrice');
	$api->get('/getOrderPageDefault', 'UserCenterPageController@init');

    $api->get('/getFreightByCity', 'freightsDataController@getFreightByCity');

    $api->get('/getWebPriceByDate', 'GetSteelDataController@getWebPriceByDate');

    $api->get('/getBrandSpec', 'PurchasePageController@getBrandSpec');
    $api->get('/getBrandGroupSpec', 'PurchasePageController@getBrandGroupSpec');


    $api->get('/getPriceTimesByDate', 'WebPricePageController@getPriceTimesByDate');
    $api->post('/addProjectDatas', 'UserDealPageController@addProject');
    $api->get('/getMainDatasByDate', 'MainPricePageController@getMainDatasByDate');
    $api->post('/editProjectDatas', 'UserCenterPageController@editProject');
	$api->get('/delProjectDatas', 'UserCenterPageController@delProject');
    $api->get('/getSettlementInfo', 'UserDealPageController@getSettlementInfo');
	$api->get('/getPriceDatasByDate', 'UserDealPageController@getPriceDatasByDate');
	$api->get('/changesProjectContact', 'UserCenterPageController@changesProjectContact');
	$api->get('/cancelProjectContact', 'UserCenterPageController@cancelProjectContact');
	$api->get('/getUserProjectDatas', 'DataProjectController@getUserProjectAndCompanyList');
	$api->get('/getBrandsElseName', function(App\Models\Steel_factory $Steel_factory){
		return array('data'=>['nameList'=>$Steel_factory::all()],'message'=>'success','status_code'=>200);
	});

    $api->get('/getAllProduct', 'ResourcesPageController@getAllProduct');
    $api->get('/getResourceAnalysis', 'ResourcesPageController@getResourceAnalysis');
    $api->get('/getResourceInfo', 'ResourcesPageController@getResourceInfo');
    $api->get('/getPriceGroupByBrand', 'ResourcesPageController@getPriceGroupByBrand');


    $api->get('/getUserInfo', 'UserInfoController@getUserInfo');
    $api->post('/modifyPassword', 'UserInfoController@modifyPassword');

	// admin
    # 报价相关
	$api->get('/getInitDatas', 'DataMarketPriceController@getInitDatas');
	$api->get('/getMarketPriceBySteelAndDate', 'DataMarketPriceController@getMarketPriceBySteelAndDate');
    $api->post('/saveMarketPriceDatas', 'DataMarketPriceController@add');
    $api->get('/getMarketPriceStateByBrand', 'MarketDataHandleController@getMarketPriceStateByBrand');
    $api->get('/getRuleByBrand', 'DataMarketPriceController@getRuleByBrand');
    $api->post('/editMarketRule', 'MarketDataHandleController@edit');
    $api->post('/changsMarketPriceState', 'MarketDataHandleController@changeState');

    //sql handle
    $api->get('/setMarketPriceRule', 'sqlController@setMarketRule');

});
