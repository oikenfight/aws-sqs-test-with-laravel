<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Demo;

use App\Service\Demo\AwsSqs\DeleteAwsSqs;
use App\Service\Demo\AwsSqs\GetAwsSqs;
use Aws\Exception\AwsException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class QueueManagerController
 * @package App\Http\Controllers\Api\Demo
 */
final class QueueManagerController extends Controller
{
    public function get(GetAwsSqs $getAwsSws)
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
                $queues[] = $item;
            }
        }

        // \Log::debug('~~~~ get ~~~~~~~~~~~~~~~~~~~~~~~~~');
        // foreach ($queues as $message) {
        //     \Log::debug('-----------------');
        //     \Log::debug("message:" . $message['Body']);
        //     \Log::debug("ReceiptHandle:" . $message['ReceiptHandle']);
        // }
        // \Log::debug('');

        return response()->json([
            'result' => 'ok',
            'queues' => $queues,
        ], 200);
    }

    public function destroy(Request $request, DeleteAwsSqs $deleteAwsSqs)
    {
        // TODO: 現状だと ReceiptHandle のみから削除してるが、これは更新されている可能性がある。
        // device（電話番号）から QueueManager で管理してる最新の ReceiptHandle を検索して、それを用いるべき。
        // redis 辺りを使うとできるようになりそう。

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
