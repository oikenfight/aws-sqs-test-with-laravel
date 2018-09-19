<?php
declare(strict_types=1);

namespace App\Service\Demo\AwsSns;

use Aws\Sns\SnsClient;
use AWS;
use Illuminate\Support\Facades\App;

class AwsSns
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
        // $this->client = AWS::createClient('sns');
        $this->client = App::make('aws')->createClient('sns');
    }
}
