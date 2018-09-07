<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Service\SqsDelete;
use App\Service\SqsGet;
use App\Service\SqsSend;
use Aws\Exception\AwsException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SqsController
 * @package App\Http\Controllers\Api
 */
final class SqsController extends Controller
{
    /**
     * @param Request $request
     * @param SqsSend $sqsSend
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request, SqsSend $sqsSend)
    {
        $input = $request->input();

        try{
            $sqsSend($input['message']);
        } catch(AwsException $e){
            return response()->json([
                'result' => 'ng'
            ], 500);
        }

        return response()->json([
            'result' => 'ok'
        ], 200);
    }

    /**
     * @param SqsGet $sqsGet
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(SqsGet $sqsGet)
    {
        try{
            $data = $sqsGet();
        } catch(AwsException $e){
            return response()->json([
                'result' => 'ng'
            ], 500);
        }

        // \Log::debug($data);

        $messages = [];
        if($data){
            foreach($data as $item){
                $messages[] = $item;
            }
        }

        \Log::debug('~~~~ get ~~~~~~~~~~~~~~~~~~~~~~~~~');
        \Log::debug($messages);
        \Log::debug('~~~~ get ~~~~~~~~~~~~~~~~~~~~~~~~~');

        return response()->json([
            'result' => 'ok',
            'messages' => $messages,
        ], 200);
    }

    /**
     * @param Request $request
     * @param SqsDelete $sqsDelete
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, SqsDelete $sqsDelete)
    {
        $queue = $request->all();

        \Log::debug('=== delete ================');
        \Log::debug($queue);
        \Log::debug('=== delete ================');

        try{
            $sqsDelete($queue);
        } catch(AwsException $e){
            return response()->json([
                'result' => 'ng'
            ], 500);
        }

        return response()->json([
            'result' => 'ok',
        ], 200);
    }
}
