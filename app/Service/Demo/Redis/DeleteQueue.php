<?php
declare(strict_types=1);

namespace App\Service\Demo\Redis;

use Illuminate\Support\Facades\Redis;

/**
 * Class SetQueues
 * @package App\Service\Demo\Redis
 */
class DeleteQueue
{
    public function __invoke($queue)
    {
        Redis::del([$queue['device']]);
    }
}
