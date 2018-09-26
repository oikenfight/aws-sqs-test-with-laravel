<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Demo;

use App\Service\Demo\AwsSns\SendAwsSns;
use Aws\Exception\AwsException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class FrontController
 * @package App\Http\Controllers\Api\Demo
 */
final class FrontController extends Controller
{
    /**
     * @param Request $request
     * @param SendAwsSns $sendAwsSns
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request, SendAwsSns $sendAwsSns)
    {
        $input = $request->input();

        try{
            $sendAwsSns($input['phone_number'], $input['message']);
        } catch(AwsException $e){
            \Log::debug($e);
            return response()->json([
                'result' => 'ng'
            ], 500);
        }

        return response()->json([
            'result' => 'ok'
        ], 200);
    }
}
