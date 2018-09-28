<?php
declare(strict_types=1);

namespace App\Service\Demo\Redis;

use Illuminate\Support\Facades\Redis;

/**
 * Class AllQueues
 * @package App\Service\Demo\Redis
 */
class AllQueues
{
    /**
     * @return array
     */
    public function __invoke()
    {
        $keys = Redis::keys('*');

        $items = Redis::pipeline(function ($pipe) use ($keys) {
            foreach ($keys as $key) {
                $pipe->hGetAll($key);
            }
        });

        return $items;
    }
}
