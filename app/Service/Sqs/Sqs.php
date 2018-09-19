<?php
declare(strict_types=1);

namespace App\Service\Sqs;

use Aws\Sqs\SqsClient;
use AWS;

class Sqs
{
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
