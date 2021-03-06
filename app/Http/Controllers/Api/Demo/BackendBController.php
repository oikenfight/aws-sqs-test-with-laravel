<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class BackendBController
 * @package App\Http\Controllers\Api\Demo
 */
final class BackendBController extends Controller
{
    public function index(Request $request)
    {
        \Log::debug($request->input());
        return 'posted to Backend B';
    }
}
