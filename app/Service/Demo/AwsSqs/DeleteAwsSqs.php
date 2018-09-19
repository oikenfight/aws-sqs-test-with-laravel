<?php
declare(strict_types=1);

namespace App\Service\Demo\AwsSqs;

/**
 * Class SqsDelete
 * @package App\Service
 */
class DeleteAwsSqs extends AwsSqs
{
    public function __invoke(array $queue)
    {
        //受け取って処理が終わったら削除する
        $this->client->deleteMessage([
            'QueueUrl' => config('aws.sqs_url'),
            'ReceiptHandle' => $queue['ReceiptHandle'],
        ]);

        return true;
    }
}
