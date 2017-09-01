<?php 
	Auth::routes();
	Route::get('/', function () {
	     return Redirect::to('/home');
	});
	Route::get('/home', 'HomeController@index');
 ?>