<?php
declare(strict_types=1);

namespace App\Service;

use Aws\Exception\AwsException;
use AWS;

class SqsGet extends Sqs
{
    public function __invoke()
    {
        // この辺のパラメータがいまいちわかってない。。
        $receive = [
            'AttributeNames' => ['All'],
            'MessageAttributeNames' => ['All'],
            'MaxNumberOfMessages' => 10,
            'QueueUrl' => self::QUEUE_URL,
            'WaitTimeSeconds' => 0,
            'VisibilityTimeout' => 60,
        ];

        $result = $this->client->receiveMessage($receive);

        $data = $result->get('Messages');

        return $data;
    }
}
