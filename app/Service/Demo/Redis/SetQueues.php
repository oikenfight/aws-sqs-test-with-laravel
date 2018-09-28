<?php
declare(strict_types=1);

namespace App\Service\Demo\Redis;

use Illuminate\Support\Facades\Redis;

/**
 * Class SetQueues
 * @package App\Service\Demo\Redis
 */
class SetQueues
{
    public function __invoke(array $queues)
    {
        foreach ($queues as $queue) {
            // 既存のデータを一旦削除
            Redis::del([$queue['device']]);

            // 新たに Redis にセット
            Redis::hMSet($queue['device'], [
                'device' => $queue['device'],     // key と重複になるけど、取り出す時に扱いやすくするため。
                'body' => $queue['body'],
                'ReceiptHandle' => $queue['ReceiptHandle'],
                'received_at' => $queue['received_at'],
            ]);
        }
    }
}
