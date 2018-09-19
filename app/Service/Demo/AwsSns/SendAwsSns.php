<?php
declare(strict_types=1);

namespace App\Service\Demo\AwsSns;

/**
 * Class AwsSnsSend
 * @package App\Service\Demo\AwsSns
 */
class SendAwsSns extends AwsSns
{
    /**
     * @param $message
     * @return \Aws\Result
     */
    public function __invoke($phoneNumber, $message)
    {
        $params = [
            'TargetArn' => config('aws.sns_target_arn'),
            'Message' => $message,
        ];

        $result = $this->client->publish($params);

        \Log::debug('sent by sns');
        \Log::debug($result);

        return $result;
    }
}
