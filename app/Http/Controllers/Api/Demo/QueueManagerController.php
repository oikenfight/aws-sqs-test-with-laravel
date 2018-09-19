<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Demo;

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

        \Log::debug('~~~~ get ~~~~~~~~~~~~~~~~~~~~~~~~~');
        foreach ($queues as $message) {
            \Log::debug('-----------------');
            \Log::debug("message:" . $message['Body']);
            \Log::debug("ReceiptHandle:" . $message['ReceiptHandle']);
        }
        \Log::debug('');

        return response()->json([
            'result' => 'ok',
            'queues' => $queues,
        ], 200);
    }

    public function send()
    {
        return 'QueueManager send';
    }

    public function destroy()
    {
        return 'QueueManager destroy';
    }
}
