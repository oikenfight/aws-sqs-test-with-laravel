<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class FrontController
 * @package App\Http\Controllers\Api\Demo
 */
final class FrontController extends Controller
{
    public function send()
    {
        return 'Front send';
    }
}
