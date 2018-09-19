<?php
declare(strict_types=1);

namespace App\Service\Demo\AwsSqs;

/**
 * Class AwsSqsGet
 * @package App\Service\Sqs
 */
class GetAwsSqs extends AwsSqs
{
    public function __invoke()
    {
        // この辺のパラメータがいまいちわかってない。。
        $receive = [
            'AttributeNames' => ['All'],
            'MessageAttributeNames' => ['All'],
            'MaxNumberOfMessages' => 10,
            'QueueUrl' => config('aws.sqs_url'),
            'WaitTimeSeconds' => 10,
            'VisibilityTimeout' => 30,
        ];

        $result = $this->client->receiveMessage($receive);

        $data = $result->get('Messages');

        return $data;
    }
}
