<?php
declare(strict_types=1);

namespace App\Service\Demo\AwsSqs;

use Aws\Sqs\SqsClient;
use AWS;
use Illuminate\Support\Facades\App;

/**
 * Class AwsSqs
 * @package App\Service\Demo\AwsSqs
 */
class AwsSqs
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
        $this->client = App::make('aws')->createClient('sqs');
    }
}
