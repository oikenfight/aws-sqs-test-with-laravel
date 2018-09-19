<?php
declare(strict_types=1);

namespace App\Service\Sns;

use Aws\Sns\SnsClient;
use AWS;

class Sns
{
    /**
     * @var SnsClient
     */
    protected $client;

    /**
     * Sns constructor.
     */
    public function __construct()
    {
        $this->client = AWS::createClient('sns');
    }
}
