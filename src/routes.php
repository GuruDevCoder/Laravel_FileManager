<?php


Route::get('/laravel-filemanager', 'Tsawler\Laravelfilemanager\controllers\LfmController@show');

Route::post('/laravel-filemanager/upload', 'Tsawler\Laravelfilemanager\controllers\LfmController@upload');

Route::get('/laravel-filemanager/data', 'Tsawler\Laravelfilemanager\controllers\LfmController@getData');

Route::get('/laravel-filemanager/delete', 'Tsawler\Laravelfilemanager\controllers\LfmController@getDelete');
