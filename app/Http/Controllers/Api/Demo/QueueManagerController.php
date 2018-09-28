<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Demo;

use App\Service\Demo\AwsSqs\DeleteAwsSqs;
use App\Service\Demo\AwsSqs\GetAwsSqs;
use App\Service\Demo\Redis\SetQueues;
use Aws\Exception\AwsException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class QueueManagerController
 * @package App\Http\Controllers\Api\Demo
 */
final class QueueManagerController extends Controller
{
    /**
     * @param GetAwsSqs $getAwsSws
     * @param SetQueues $setQueues
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(GetAwsSqs $getAwsSws, SetQueues $setQueues)
    {
        try{
            $data = $getAwsSws();
        } catch(AwsException $e){
            return response()->json([
                'result' => 'ng'
            ], 500);
        }

        $queues = [];
        if($data){
            foreach($data as $item){
                $body = json_decode($item['Body']);
                $message = json_decode($body->Message);
                $value = [
                    'device' => $message->device,
                    'body' => $message->body,
                    'ReceiptHandle' => $item['ReceiptHandle'],
                    'received_at' => Carbon::now(),
                ];
                $queues[] = $value;
            }
        }

        $setQueues($queues);

        return response()->json([
            'result' => 'ok',
            // 'queues' => $queues,
        ], 200);
    }

    public function destroy(Request $request, DeleteAwsSqs $deleteAwsSqs)
    {
        $data = $request->all();

        \Log::debug('=== delete ================');
        \Log::debug($data['queue']);
        \Log::debug('=== delete ================');

        try{
            $deleteAwsSqs($data['queue']);
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
