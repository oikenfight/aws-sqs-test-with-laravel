<?php
declare(strict_types=1);

namespace App\Service\Demo\Redis;

use Illuminate\Support\Facades\Redis;

class GetQueues
{
    /**
     * @param array $devices
     * @return mixed
     */
    public function __invoke(array $devices)
    {
        $keys = $devices;

        $items = Redis::pipeline(function ($pipe) use ($keys) {
            foreach ($keys as $key) {
                $pipe->hGetAll($key);
            }
        });

        // key のデータが存在しない場合、空配列が混入しているため、取り除く。
        $items = array_values(array_filter($items));

        return $items;
    }
}
