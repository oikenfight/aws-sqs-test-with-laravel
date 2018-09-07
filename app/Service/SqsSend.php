<?php
declare(strict_types=1);

namespace App\Service;

use Aws\AwsClient;
use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;
use Illuminate\Support\Facades\App;
use AWS;

class SqsSend extends Sqs
{
    /**
     * @param $message
     * @return \Aws\Result
     */
    public function __invoke($message)
    {
        $params = [
            'DelaySeconds' => 0,
            'MessageAttributes' => [
                'Title' => [
                    'DataType' => 'String',
                    'StringValue' => 'Amazon SQS Test',
                ]
            ],
            'MessageBody' => $message,
            'QueueUrl' => self::QUEUE_URL,
        ];

        $result = $this->client->sendMessage($params);
        \Log::debug('sent');
        \Log::debug($result);

        return $result;
    }
}
