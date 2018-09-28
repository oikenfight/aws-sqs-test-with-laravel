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

// demo
Route::group(['prefix' => 'demo'], function () {
    // front
    Route::post('front/send', [
        'uses' => 'Api\Demo\FrontController@send',
        'as' => 'demo.api.front.send',
    ]);

    // queue manager
    Route::get('queue_manager/get', [
        'uses' => 'Api\Demo\QueueManagerController@get',
        'as' => 'api.demo.queue_manager.get',
    ]);
    Route::delete('queue_manager/destroy', [
        'uses' => 'Api\Demo\QueueManagerController@destroy',
        'as' => 'api.demo.queue_manager.destroy',
    ]);

    // backendA
    Route::post('backendA', [
        'uses' => 'Api\Demo\BackendAController@index',
        'as' => 'api.demo.backend_a.index',
    ]);

    // backendB
    Route::post('backendB', [
        'uses' => 'Api\Demo\BackendBController@index',
        'as' => 'api.demo.backend_b.index',
    ]);

    // backendC
    Route::post('backendC', [
        'uses' => 'Api\Demo\BackendCController@index',
        'as' => 'api.demo.backend_c.index',
    ]);

    // Redis
    Route::get('redis/queues', [
        'uses' => 'Api\Demo\RedisQueuesController@index',
        'as' => 'api.demo.redis.queues.all',
    ]);
    Route::get('redis/queues/{BackendApp}', [
        'uses' => 'Api\Demo\RedisQueuesController@getBackendAppQueues',
        'as' => 'api.demo.redis.queues.backend_app_queues',
    ]);
    Route::delete('redis/queues/{Device}', [
        'uses' => 'Api\Demo\RedisQueuesController@destroy',
        'as' => 'api.demo.redis.queues.destroy',
    ]);

});
