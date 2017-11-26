<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;

class Controller extends BaseController
{
    use ValidatesRequests;

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatePhone(Request $request)
    {
        $response = [];

            $parameters = $request->input('parameters');

            $validator = Validator::make($request->only(['number', 'number_country']), [
                'number' => 'phone' . ($parameters ? ':' . $parameters : null),
            ]);

            $response['validation'] = $validator->passes() ? 'PASSES' : 'FAILED';
            $response['errors'] = $validator->errors();

        return response()->json($response);
    }
}
