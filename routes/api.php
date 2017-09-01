<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




/*
|--------------------------------------------------------------------------
| API Data
|--------------------------------------------------------------------------
|
|
*/

// Route::group(['middleware' => 'cors'], function () {

// 后台数据管理页面

    // 市场价格模块
    Route::get('/allspecs', 'DatasController@allspecs');
    Route::get('/getAllspecsAndNotice', 'DatasController@getAllspecsAndNotice');
    Route::get('/getDataFromSetting', 'DatasController@getDataFromSetting');
    Route::get('/getMarketData', 'DatasController@getMarketData');
    Route::post('/editMarketData', 'DatasController@editMarketData')/*->middleware('apitest:编辑报价')*/;
    Route::post('/createMarketPrice', 'DatasController@createMarketPrice')/*->middleware('apitest:编辑报价')*/;
    Route::get('/createMarketRecord', 'DatasController@createMarketRecord')/*->middleware('apitest：新增报价')*/;
    Route::get('/getLastMarketPrice', 'DatasController@getLastMarketPrice');
    Route::get('/delMarketDatas', 'DatasController@delMarketDatas')/*->middleware('apitest:删除报价')*/;
    Route::get('/reportMarketData', 'DatasController@reportMarketData')/*->middleware('apitest:发布报价')*/;
    Route::get('/getMarketDatasAtDate', 'DatasController@getMarketDatasAtDate');
    Route::get('/getPrveMarketData', 'DatasController@getPrveMarketData');
    Route::post('/fillMarketPrice', 'DatasController@fillMarketPrice');

        // 报价来源模块
        Route::post('/createPriceSource', 'DatasController@createPriceSource');
        Route::post('/editPriceSource', 'DatasController@editPriceSource');
        Route::post('/delPriceSource', 'DatasController@delPriceSource');
        // 仓库模块
        Route::post('/createWarehouse', 'DatasController@createWarehouse');
        Route::post('/editWarehouse', 'DatasController@editWarehouse');
        Route::post('/delWarehouse', 'DatasController@delWarehouse');
        // 付款选项模块
        Route::post('/createPaymentKind', 'DatasController@createPaymentKind');
        Route::post('/editPaymentKind', 'DatasController@editPaymentKind');
        Route::post('/delPaymentKind', 'DatasController@delPaymentKind');

    // 运费价格模块
    Route::post('/createFreightPrice', 'DatasController@createFreightPrice');
    Route::get('/getFreightPrice', 'DatasController@getFreightPrice');
    Route::post('/editFreightPrice', 'DatasController@editFreightPrice');
    Route::post('/delFreightPrice', 'DatasController@delFreightPrice');

    // 网价数据的接口
    Route::get('/initForGetWebPrice', 'GetSteelDataController@initForGetWebPrice');
    Route::get('/getWebPriceDate', 'GetSteelDataController@getWebPriceDate');
    Route::get('/checkWebPriceData', 'GetSteelDataController@checkWebPriceData');
    Route::post('/saveWebPriceData', 'GetSteelDataController@saveWebPriceData');
    Route::post('/updateWebPriceData', 'GetSteelDataController@updateWebPriceData');



    // 风险提示设置
    Route::get('/getNoticeDatas', 'DatasController@getNoticeDatas')/*->middleware('apitest:前台浮动设置')*/;
    Route::post('/createPriceNotice', 'DatasController@createPriceNotice')/*->middleware('apitest:前台浮动设置')*/;
    Route::post('/editNoticeDatas', 'DatasController@editNoticeDatas')/*->middleware('apitest:前台浮动设置')*/;
    Route::post('/deleteNoticeDatas', 'DatasController@deleteNoticeDatas')/*->middleware('apitest:前台浮动设置')*/;


// 钢材价格页面
    Route::get('/getSteelMarketList', 'DatasController@getSteelMarketList');
    Route::get('/getSteelMarketDatas', 'DatasController@getSteelMarketDatas');
    Route::get('/searchTransportForCity', 'DatasController@searchTransportForCity');
    Route::get('/getProjectFromeUser', 'DatasController@getProjectFromeUser');


// 资源推荐页面
    Route::get('/getRecommendingResource', 'DatasController@getRecommendingResource');
    Route::get('/brandsDiff', 'DatasController@brandsDiff');

// 运费
    Route::get('/getAllFreightsData', 'freightsDataController@getAllFreightsData');
    Route::get('/seachFreightRecord', 'freightsDataController@seachFreightRecord');

//历史数据
    Route::post('/seachHistoryPrice', 'historyDataController@seachHistoryPrice');
        Route::post('/getProductsData', 'historyDataController@getProductsData');
        Route::get('/getFactorys', 'historyDataController@getFactorys');
// other
    Route::get('/getRecordFromDate', 'DatasController@getRecordFromDate');

// public
    //
    Route::get('/getAllbrands', 'DatasController@getAllbrands');
    Route::get('/getAllHasbrands', 'DatasController@getAllHasbrands');
    Route::get('/getToken', 'DatasController@getToken');
    Route::get('/getAllBrandsWillHeader', 'DatasController@getAllBrandsWillHeader');



    // 后台数据管理页面列表获取
    Route::get('/listData', 'DatasController@getListData');

    // 更新数据平均数
    Route::get('/updateBrandDataMean', 'DatasController@updateBrandDataMean');

    //定价规则
    Route::get('/marketDataHandle', 'MarketDataHandleController@marketDataHandle');
    Route::get('/getRule', 'MarketDataHandleController@getRule');
    Route::get('/getRuleData', 'MarketDataHandleController@getRuleData');

    //Test
    Route::get('/test_path', 'DatasController@showTable');
    //获取钢材信息所有数据
    Route::get('/getSteelInfo', 'GetSteelDataController@getSteelInfo');

    Route::get('/getSteelBrandSource', 'getSteelDataController@getSteelBrandSource');

    //订单
    Route::get('/getUserProjectOrder', 'UserOrderController@getUserProjectOrder');
    Route::get('/getUserProject', 'UserOrderController@getUserProject');
    // Route::get('/getProjectOrder', 'UserOrderController@getProjectOrder');
    // Route::get('/getUserProject', 'UserOrderController@getUserProject');

    //用户订单查询
    // Route::get('/getProjectOrder', 'ProjectOrderController@getProjectOrder');
// });


    

    // 临时路由
    Route::get('/tempGetLastDatas', 'v1\WebPricePageController@tempGetLastDatas');
    Route::get('/tempGetLastDatas', 'v1\UserDealPageController@getLastPriceDatas');
