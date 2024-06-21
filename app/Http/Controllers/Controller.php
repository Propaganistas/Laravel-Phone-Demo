<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class Controller extends BaseController
{
    public function index(Request $request)
    {
        return view('page');
    }

    public function validate(Request $request)
    {
        $data = ['field' => $request->get('phone')];

        if ($request->boolean('with_country')) {
            $data[$request->get('country_name') ?: 'field_country'] = $request->get('country');
        }

        $rules = [
            'field' => explode('|', $request->input('parameters')),
        ];

        $validator = Validator::make($data, $rules);

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
