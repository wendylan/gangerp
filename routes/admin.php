<?php

Route::get('/steelspec/test', 'SteelSpecCrudController@test');
Route::group(['middleware' => ['role:后台数据录入']], function () {

    CRUD::resource('item', 'ItemCrudController');
    CRUD::resource('steel_brands', 'Steel_brandsCrudController');
    CRUD::resource('steel_factory', 'Steel_factoryCrudController');
    CRUD::resource('steelspec', 'SteelSpecCrudController');
    CRUD::resource('product', 'productCrudController');


});
//    Route::get('/steelspec/test', function (){echo "aaaaaaaaa";});