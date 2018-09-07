<?php
declare(strict_types=1);

namespace App\Service;

use Aws\AwsClient;
use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;
use Illuminate\Support\Facades\App;
use AWS;

class SqsSend
{
    const QUEUE_URL = 'https://sqs.ap-northeast-1.amazonaws.com/269017295587/sqs_test';

    public function __invoke()
    {
        try{
            // TODO: AWS の alias がうまく使えなくて困ってる。。
            /** @var Aws\Sqs\SqsClient $client */
            $client = AWS::createClient('sqs');

            $params = [
                'DelaySeconds' => 0,
                'MessageAttributes' => [
                    'Title' => [
                        'DataType' => 'String',
                        'StringValue' => 'Amazon SQS Test',
                    ]
                ],
                'MessageBody' => 'This is Amazon SQS Test',
                'QueueUrl' => self::QUEUE_URL,
            ];

            $result = $client->sendMessage($params);
            \Log::debug('sent');
            \Log::debug($result);
            return $result;
        } catch(AwsException $e){
            \Log::debug('error');
            \Log::debug($e->getMessage());
        }
    }
}
