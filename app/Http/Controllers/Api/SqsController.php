<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Service\SqsGet;
use App\Service\SqsSend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SqsController
 * @package App\Http\Controllers\Api
 */
final class SqsController extends Controller
{
    public function send(SqsSend $sqsSend)
    {
        $sqsSend();
        return 'sqs send';
    }

    public function get(SqsGet $sqsGet)
    {
        $sqsGet();
        return 'sqs get';
    }
}
