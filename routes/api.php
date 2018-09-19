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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'sqs_test'], function () {
    Route::post('send', [
        'uses' => 'Api\SqsController@send',
        'as' => 'api.sqs_test.send',
    ]);
    Route::get('get', [
        'uses' => 'Api\SqsController@get',
        'as' => 'api.sqs_test.get',
    ]);
    Route::delete('delete', [
        'uses' => 'Api\SqsController@delete',
        'as' => 'api.sqs_test.delete',
    ]);
});

Route::group(['prefix' => 'sns_test'], function () {
    Route::post('send', [
        'uses' => 'Api\SqsController@send',
        'as' => 'api.sns_test.send',
    ]);
    Route::get('get', [
        'uses' => 'Api\SqsController@get',
        'as' => 'api.sns_test.get',
    ]);
    Route::delete('delete', [
        'uses' => 'Api\SqsController@delete',
        'as' => 'api.sns_test.delete',
    ]);
});
