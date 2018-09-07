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
    Route::get('send', [
        'uses' => 'Api\SqsController@send',
        'as' => 'api.sqs_test.send',
    ]);
    Route::get('get', [
        'uses' => 'Api\SqsController@get',
        'as' => 'api.sqs_test.get',
    ]);
});
