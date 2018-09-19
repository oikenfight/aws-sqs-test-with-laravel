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
    public function get()
    {
        return 'Backend B get';
    }

    public function destroy()
    {
        return 'Backend B destroy';
    }
}
