<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/




// Auth::routes();


// Route::get('/bids/create', 'BidsController@create');




// 数据产品
Route::group(['middleware' => ['role:前台数据管理员']], function () {
    Route::get('/index', function () {
        return view('index');
    });
    Route::get('/freight', function () {
        return view('freight');
    });
    Route::get('/historyData', function () {
        return view('historyData');
    });
    Route::get('/userOrder', function () {
        return view('userOrder');
    });
    Route::get('/priceInfo', function () {
        return view('priceInfo');
    });
    Route::get('/sourceRecommend', function () {
        return view('sourceRecommend');
    });
    Route::get('/index.html', function () {
        return view('index');
       });
    Route::get('/freight.html', function () {
        return view('freight');
    });
    Route::get('/historyData.html', function () {
        return view('historyData');
    });
    Route::get('/priceInfo.html', function () {
        return view('priceInfo');
    });
    Route::get('/sourceRecommend.html', function () {
        return view('sourceRecommend');
    });
    //data录入
    Route::get('/dataManage', function () {
        return view('dataManage');
    });
    Route::get('/dataManage.html', function () {
        return view('dataManage');
    });
});




//投标方
Route::group(['middleware' => ['role:bidder,bid','web']], function () {

	Route::get('bidder/allbids', 'BidsController@bidder_list');//招标公告
	Route::get('bidder/my', 'BidsController@mybids');//我的投标
	Route::get('bidder/allbids/{id}', 'BidsController@bidder_bid');
	Route::get('bidder/allbids/{id}/step2', 'BidsController@bidder_bid_step2')->middleware('StageReidrect');
	Route::get('bidder/allbids/{id}/open', 'BidsController@bidder_bid_open')->middleware('StageReidrect');
	Route::get('bidder/allbids/{id}/view_bidfile', 'BidsController@view_bidfile');

	Route::post('bidder/allbids/{id}', 'BidsController@bidder_bid_add');
	Route::post('bidder/allbids/{id}/bid2', 'BidsController@bidder_bid2_add');
	Route::post('bidder/allbids/{id}/quote', 'BidsController@bidder_bid_quote_store');
	Route::post('bidder/allbids/{id}/squote', 'BidsController@bidder_bid_squote_store');

	// Route::get('bidder/my', 'BidsController@bidder_my');
	Route::post('/bidder/audit/{id}', 'BidsController@b_audit');
});

Route::group(['middleware' => ['role:tenderee,tender']], function () {
	Route::get('/bids/create/{type?}', 'BidsController@create')->middleware('role:tenderee,录入');

	//zzzz招标方
	Route::get('tenderee/my', 'BidsController@tenderee_my');
	// Route::get('tenderee/my/{id}', 'BidsController@tenderee_my_bid')->middleware('StageReidrect');
	Route::get('tenderee/my/{id}', 'BidsController@tenderee_my_bid');
	Route::get('tenderee/my/{id}/edit', 'BidsController@tenderee_my_bid_edit');
	Route::post('tenderee/my/{id}/edit', 'BidsController@tenderee_my_bid_edit_store');
	Route::post('tenderee/my/{id}/corrections', 'BidsController@tenderee_my_bid_corrections');
	Route::get('tenderee/my/{id}/open', 'BidsController@tenderee_my_bid_open');

	Route::get('tenderee/my/{id}/open/compare', 'BidsController@tenderee_my_bid_open_compare');

	Route::post('tenderee/my/{id}/want', 'BidsController@tenderee_my_bid_want');
	Route::get('tenderee/projects', 'BidsController@tenderee_projects');
	Route::post('tenderee/my/{id}/whowin', 'BidsController@tenderee_my_bid_whowin');

	Route::get('/api/tenderee/project/{projectID}', 'ProjectsController@getProjectData');
	Route::get('/api/tenderee/project/edit/{projectID}', 'ProjectsController@getEditProjectData');
	Route::post('/api/tenderee/project/edit-form', 'ProjectsController@getEditProjectFormData');
	Route::post('/api/tenderee/delete-bid', 'BidsController@deleteBid');

	Route::get('tenderee/view_bidfile/{uid}/{id}', 'BidsController@view_bidfile_by_uid_bid');

	Route::resource('bids', 'BidsController',['except' => [
	    'create'
	]]);

	Route::resource('projects', 'ProjectsController');

	// Route::post('/tenderee/audit/review', 'ProjectsController@getEditProjectFormData');
	//招标方审核
	Route::post('/tenderee/audit/{id}', 'BidsController@t_audit');


});

//招标文件
Route::get('/allbids/{id}/tfile', 'BidsController@tfile');
Route::get('/allbids/{id}/tpdf', 'BidsController@tpdf');

Route::get('/bid/{id}/over', 'BidsController@bid_over')->middleware('auth');




// Route::get('/message', function(){
// 	return view("message-center");
// });
Route::get('/message', 'MessageController@show');

//审核
Route::get("/review",'MessageController@show');
// API : 提交审核资料
Route::post("/api/review", 'userController@reviewUser');
// 视图 : Admin审核
Route::get("/admin/review", 'reviewController@getReviewList');
// API : 请求指定账户信息
Route::post('/api/get-review-data', 'reviewController@getReviewData');
// API : 通过审核
Route::post('/api/pass-review', 'reviewController@passReview');

Route::get('center/accounts', 'centerController@getChildAccounts');

Route::get('center/company-info', 'centerController@getCompanyInfo');

Route::get('center/account-safe', function(){ return view('user-center/forget_password'); });

Route::post('api/center/accounts/update', 'centerController@updateAccountInfo');

Route::post('api/center/accounts/create', 'centerController@create');

Route::post('api/center/accounts/delete', 'centerController@delete');

Route::post('api/center/account-safe/password', 'centerController@changePassword');


//消息中心
Route::delete('users/{user}/notifications',function(App\User $user){
	$user->unreadNotifications->map(function($n){
		$n->markAsRead();
	});
	return back();
});


//我的项目
Route::get("/test/tender/projects-list",function(){
	return view("test.tenderer.userProject");
});
//我的招标
Route::get('/test/tender/tender-list', function(){
	return view("test.tenderer.userTender");
});

//招标状态与流程(公开招标)(招标方)
Route::get('/test/tender/public-selected', function(){
	return view("test/public-tender/tender/tender");
});
Route::get('/test/tender/public-selected-2', function(){
	return view("test/public-tender/tender/opening");
});

//招标状态与流程(定向招标)(招标方)
Route::get('/test/tender/private-selected/', function(){
	return view("test/private-tender/tender/tender");
});
Route::get('/test/tender/private-selected-2', function(){
	return view("test/private-tender/tender/opening");
});

//招标公告
Route::get('/test/bid/tender-list', function(){
	return view("test/bidder/all-tender-list");
});

//招标状态与流程(公开招标)(投标方)
Route::get('/test/bid/public-selected', function(){
	return view("test/public-tender/bid/enroll");
});
Route::get('/test/bid/public-selected-2', function(){
	return view("test/public-tender/bid/bid");
});
Route::get('/test/bid/public-selected-3', function(){
	return view("test/public-tender/bid/opening");
});

//招标状态与流程(公开招标)(投标方)
Route::get('/test/bid/private-selected', function(){
	return view("test/private-tender/bid/bid");
});
Route::get('/test/bid/private-selected-2', function(){
	return view("test/private-tender/bid/opening");
});

Route::get('/tender/model', function(){
	return view("test/tender-file-model");
});
Route::get('/bid/model', function(){
	return view("test/bid-file-model");
});

Route::get('/bid/over', function(){
	return view("test/over-bid");
});



//Route::get('/steelspec/testt', function (){echo "aaaaaaaaa";});

Route::get('/sendsms', 'SmsController@send');

//Route::get('/steelspec/testt', function (){echo "aaaaaaaaa";});


Route::get('/chat',function(){
	return view("chat/main");
});

// 网价
Route::get('/webprice', 'v1\WebPricePageController@getLastDayWebDatas')->middleware('checkPermission:网价');

Route::get('/stResource',function(){
	return view("SteelData/stResource");
})->middleware('checkPermission:资源推荐');

Route::group(['middleware' => ['role:次终端用户','web']], function () {
	//次终端
	Route::get('/secondaryTerminal',function(){
		return view("SteelData/secondaryTerminal");
	})->middleware('checkPermission:现货价格指数');


	Route::get('/purchase',function(){
		return view("SteelData/secondaryTerminalPurchase");
	})->middleware('checkPermission:买买买');

	// Route::get('/ordermanager',function(){
	// 	return view("SteelData/ordermanager");
	// });

	Route::get('/agentProject',function(){
		return view("SteelData/AgentProject");
	})->middleware('checkPermission:项目管理');


	Route::get('/purchaseOrder',function(){
		return view("SteelData/secondaryTerminalPurchaseOrder");
	})->middleware('checkPermission:订单管理');

    Route::get('/salesOrder',function(){
		return view("SteelData/secondaryTerminalSalesOrder");
	})->middleware('checkPermission:订单管理');
    
    Route::get('/dealing_tool', 'v1\DealingToolController@index');
    
    Route::get('/form_total', function(){
        return view("SteelData/FormTotal");
    });

	Route::get('/stUserOrder',function(){
		return view("SteelData/stUserOrder");
	})->middleware('checkPermission:订单管理');
});

Route::group(['middleware' => ['role:运营中心','web']], function () {
	Route::get('/supplier_order', 'v1\SupplierOrderController@index')->middleware('checkPermission:订单管理');
});

Route::get('/userdeal', 'v1\UserDealPageController@getLastPriceDatas')->middleware('checkPermission:下单管理');
Route::group(['middleware' => ['role:终端用户','web']], function () {
	// 新数据产品
	// 现货价
	Route::get('/mainprice', 'v1\MainPricePageController@getLastMainDatas')->middleware('checkPermission:现货价格指数');
	// 下单管理
    // 用户中心
    Route::get('/usercenter', 'v1\UserCenterPageController@index')->middleware('checkPermission:我的订单');

    Route::get('/userprojectmanager',function(){
		return view("SteelData/userprojectmanager");
	})->middleware('checkPermission:项目管理');
    // 缺货查询
    Route::get('/searchproduct', 'v1\SteelAmountPageController@index')->middleware('checkPermission:下单管理');
});

Route::get('/userInfo','UserInfoController@getCompanyInfo');
Route::get('/companyInfo', function(){
	return view("SteelData/companyInfo");
});
Route::get('/passwordModify', function(){
	return view("SteelData/passwordModify");
});

Route::post('/msg', ['uses' => 'MessageController@msg']);
Route::get('/messageList',function(){
    return view("SteelData/messageList");
});


Route::post('/ggexcel','HomeController@excel');


Route::get('/wuliu','wuliuController@index');
Route::get('/wuliu/cb','wuliuController@cb');
Route::get('/wuliu/kyt','wuliuController@kyt');

// Route::get('/captcha/{tmp}','CodeController@captcha');
// Route::post('/regsms','CodeController@regsms');