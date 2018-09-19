<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class BackendCController
 * @package App\Http\Controllers\Api\Demo
 */
final class BackendCController extends Controller
{
    public function get()
    {
        return 'Backend C get';
    }

    public function destroy()
    {
        return 'Backend C destroy';
    }
}
