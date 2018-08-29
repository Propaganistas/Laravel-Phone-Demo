<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('page');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateFields(Request $request)
    {
        $parameters = ltrim(Str::after($request->input('parameters'), 'phone'), ':');
        $countryInput = $request->input('country_name');

        $data = $request->only(array_filter(['field', $countryInput]));
        $rules = [
            'field' => 'phone' . ($parameters ? ':' . $parameters : null),
        ];

        $validator = Validator::make($data, $rules);
        $exception = null;
        $message = null;

        try {
            $passes= $validator->passes();
        } catch (\Exception $e) {
            $passes = false;
            $exception = get_class($e);
            $message = $e->getMessage();
        }

        return response()->json([
            'request' => $data,
            'rules' => $rules,
            'passes' => $passes,
            'errors' => $validator->errors(),
            'exception' => $exception,
            'message' => $message,
        ]);
    }
}
