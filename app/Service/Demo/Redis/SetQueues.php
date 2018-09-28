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
            // // 既存のデータを一旦削除
            // Redis::del([$queue['device']]);

            // TODO: 現状、同じ device 宛の queue を取得すると、既存の queue を上書きしてしまう。
            // TODO: redis の key が device だけど、Hash 値にして重複を避ける。
            // いやでも、FrontApp により、次回実行する Queue だけ redis 追加されるようになってれば、
            // そもそも重複考えなくて済んで、device を key に Queue を取得して実行するだけの簡単な状態になるかも。

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
