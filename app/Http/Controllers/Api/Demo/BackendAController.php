<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class BackendAController
 * @package App\Http\Controllers\Api\Demo
 */
final class BackendAController extends Controller
{
    public function get()
    {
        return 'Backend A get';
    }

    public function destroy()
    {
        return 'Backend A destroy';
    }
}
