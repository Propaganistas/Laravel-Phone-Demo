<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

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
        $validator = Validator::make(
            $data = $request->only(array_filter([
                'field',
                $request->input('country_name')
            ])),
            $rules = [
                'field' => Arr::wrap($request->input('parameters')),
            ]
        );

        try {
            return response()->json([
	            'request' => $data,
	            'rules' => $rules,
	            'passes' => $validator->passes(),
	            'message' => $validator->errors()->get('field') ?: '',
	            'exception' => null,
	        ]);
        } catch (\Exception $e) {
        	return response()->json([
	            'request' => $data,
	            'rules' => $rules,
	            'passes' => false,
	            'message' => $e->getMessage(),
	            'exception' => get_class($e),
	        ]);
        }
    }
}
