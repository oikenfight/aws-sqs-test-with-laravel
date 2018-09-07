<?php
declare(strict_types=1);

namespace App\Service;

use Aws\Sqs\SqsClient;
use AWS;

class Sqs
{
    const QUEUE_URL = 'https://sqs.ap-northeast-1.amazonaws.com/269017295587/sqs_test';

    /**
     * @var SqsClient
     */
    protected $client;

    /**
     * Sqs constructor.
     */
    public function __construct()
    {
        $this->client = AWS::createClient('sqs');
    }
}
