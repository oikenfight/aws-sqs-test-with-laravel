<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sqs_test', [
    'uses' => 'SqsController@index',
    'as' => 'sqs.index',
]);

Route::get('/demo', [
    'uses' => 'DemoController@index',
    'as' => 'demo.index',
]);
