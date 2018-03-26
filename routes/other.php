<?php

Route::get('/captcha/{tmp}','CodeController@captcha');
Route::post('/regsms','CodeController@regsms');