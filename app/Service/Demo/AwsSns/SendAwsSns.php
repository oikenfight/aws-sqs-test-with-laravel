<?php
declare(strict_types=1);

namespace App\Service\Demo\AwsSns;

use Aws\AwsClient;
use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Illuminate\Support\Facades\App;
use AWS;

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
            'Message' => $message,
            'PhoneNumber' => $phoneNumber,
        ];

        $result = $this->client->publish($params);

        \Log::debug('sent by sns');
        \Log::debug($result);

        return $result;
    }
}
