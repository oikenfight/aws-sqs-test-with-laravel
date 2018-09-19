<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Service\Sns\SnsSend;
use Aws\Exception\AwsException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SnsController
 * @package App\Http\Controllers\Api
 */
final class SnsController extends Controller
{
    /**
     * @param Request $request
     * @param SnsSend $snsSend
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request, SnsSend $snsSend)
    {
        $input = $request->input();

        try{
            $snsSend($input['message']);
        } catch(AwsException $e){
            return response()->json([
                'result' => 'ng'
            ], 500);
        }

        return response()->json([
            'result' => 'ok'
        ], 200);
    }
}
