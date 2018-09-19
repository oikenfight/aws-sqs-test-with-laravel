<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class QueueManagerController
 * @package App\Http\Controllers\Api\Demo
 */
final class QueueManagerController extends Controller
{
    public function get()
    {
        return 'QueueManager get';
    }

    public function send()
    {
        return 'QueueManager send';
    }

    public function destroy()
    {
        return 'QueueManager destroy';
    }
}
