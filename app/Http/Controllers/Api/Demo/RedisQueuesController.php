<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Demo;

use App\Service\Demo\Redis\AllQueues;
use App\Service\Demo\Redis\GetQueues;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class RedisQueuesController
 * @package App\Http\Controllers\Api\Demo
 */
final class RedisQueuesController extends Controller
{
    protected $devices = [
        'BackendAppA' => [
            '08000000000',
            '08000000001',
            '08000000002',
            '08000000003',
        ],
        'BackendAppB' => [
            '08000000004',
            '08000000005',
            '08000000006',
        ],
        'BackendAppC' => [
            '08000000007',
            '08000000008',
            '08000000009',
        ],
    ];

    /**
     * @param AllQueues $allQueues
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AllQueues $allQueues)
    {
        try{
            $queues = $allQueues();
        } catch(\Exception $e){
            return response()->json([
                'result' => 'ng'
            ], 500);
        }

        return response()->json([
            'result' => 'ok',
            'queues' => $queues,
        ], 200);
    }

    /**
     * @param Request $request
     * @param GetQueues $getQueues
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBackendAppQueues(Request $request, GetQueues $getQueues)
    {
        $target = $request->route('BackendApp');

        try{
            $queues = $getQueues($this->devices[$target]);
        } catch(\Exception $e){
            return response()->json([
                'result' => 'ng'
            ], 500);
        }

        return response()->json([
            'result' => 'ok',
            'queues' => $queues,
        ], 200);
    }

    public function destroy(Request $request)
    {
        return 'destroy';
    }
}
