<?php
declare(strict_types=1);

namespace App\Service\Sns;

use Aws\AwsClient;
use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Illuminate\Support\Facades\App;
use AWS;

class SnsSend extends Sns
{
    /**
     * @param $message
     * @return \Aws\Result
     */
    public function __invoke($message)
    {
        $params = [
            'MessageAttributes' => [],
            'MessageBody' => $message,
        ];

        $result = $this->client->publish($params);

        \Log::debug('sent by sns');
        \Log::debug($result);

        return $result;
    }
}
