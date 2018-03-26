<?php
	Auth::routes();
	Route::get('/', function () {
	     return Redirect::to('/companyInfo');
	});
	Route::get('/home', 'HomeController@index');
	Route::get('/stindex',function(){
		return view("SteelData/secondaryTerminalIndex");
	});
	Route::get('/signCompany',function(){
		return view("SteelData/signCompany");
	});
	Route::get('/resetPassword',function(){
		return view("SteelData/resetPassword");
	});

    Route::get('/retrievePassword', function () {
        return view("SteelData/retrievePassword");
	});
 ?>
