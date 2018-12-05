<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use League\ISO3166\ISO3166;

class Controller extends BaseController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('page')->with([
            'countries' => with(new ISO3166)->all(),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateFields(Request $request)
    {
        $parameters = ltrim(Str::after($request->input('parameters'), 'phone'), ':');
        
        $validator = Validator::make(
            $data = $request->only(array_filter([
                'field',
                $request->input('country_name')
            ])),
            $rules = [
                'field' => 'phone' . ($parameters ? ':' . $parameters : null),
            ]
        );

        try {
            $passes= $validator->passes();
        } catch (\Exception $e) {
            $exception = get_class($e);
            $message = $e->getMessage();
        }

        return response()->json([
            'request' => $data,
            'rules' => $rules,
            'passes' => $passes ?? false,
            'errors' => $validator->errors(),
            'exception' => $exception ?? null,
            'message' => $message ?? null,
        ]);
    }
}
