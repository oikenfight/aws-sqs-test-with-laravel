<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class SqsController
 * @package App\Http\Controllers
 */
final class SqsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('sqs.index');
    }
}
