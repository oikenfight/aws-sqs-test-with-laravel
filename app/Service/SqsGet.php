<?php
declare(strict_types=1);

namespace App\Service;

use Aws\Exception\AwsException;
use AWS;

class SqsGet
{
    const QUEUE_URL = 'https://sqs.ap-northeast-1.amazonaws.com/269017295587/sqs_test';

    public function __invoke()
    {
        try{
            $client = AWS::createClient('sqs');

            $receive = [
                'AttributeNames' => ['All'],
                'MessageAttributeNames' => ['All'],
                'MaxNumberOfMessages' => 10,
                'QueueUrl' => self::QUEUE_URL,
                'WaitTimeSeconds' => 20,
                'VisibilityTimeout' => 60,
            ];

            $result = $client->receiveMessage($receive);
            // \Log::debug(get_class($result));
            // \Log::debug($result);
            $data = $result->get('Messages');
            if($data){
                \Log::debug('got');
                \Log::debug($data);
                foreach($data as $item){
                    \Log::debug('delete');
                    \Log::debug($item['Body']);
                    //受け取って処理が終わったら削除する
                    $client->deleteMessage([
                        'QueueUrl' => self::QUEUE_URL,
                        'ReceiptHandle' => $item['ReceiptHandle'],
                    ]);
                }
            }
            return $data;
        } catch(AwsException $e){
            \Log::debug('error');
            \Log::debug($e->getMessage());
        }
    }
}
