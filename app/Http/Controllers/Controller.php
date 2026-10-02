<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Propaganistas\LaravelPhone\Rules\Phone;
use ReflectionClass;

class Controller extends BaseController
{
    public function index(Request $request)
    {
        return view('page');
    }

    public function validate(Request $request)
    {
        Phone::setDefaultCountry($request->array('default_countries'));

        $data = ['field' => $request->input('phone')];

        if ($request->boolean('with_country')) {
            $data[$request->input('country_name') ?: 'field_country'] = $request->input('country');
        }

        $validator = Validator::make($data, [
            'field' => $rules = collect(explode('|', $request->input('parameters'))),
        ]);

        $displayedRules = $rules->map(fn ($rule) => str_starts_with($rule, 'phone:')
            ? $this->insertDefaultCountriesInPhoneRuleIfApplicable($data, $rule)
            : $rule
        );

        try {
            return response()->json([
	            'request' => $data,
	            'rules' => $displayedRules,
	            'passes' => $validator->passes(),
	            'message' => $validator->errors()->get('field') ?: '',
	            'exception' => null,
	        ]);
        } catch (\Exception $e) {
        	return response()->json([
	            'request' => $data,
	            'rules' => $displayedRules,
	            'passes' => false,
	            'message' => $e->getMessage(),
	            'exception' => get_class($e),
	        ]);
        }
    }

    protected function insertDefaultCountriesInPhoneRuleIfApplicable($data, string $rule): string
    {
        $parameters = explode(',', str_replace('phone:', '', $rule));

        $phoneRule = (new Phone)->setData($data)->setParameters($parameters);

        $prop = new ReflectionClass($phoneRule)->getProperty('countries');
        $prop->setAccessible(true);
        $countries = $prop->getValue($phoneRule);

        if (! empty($countries)) {
            return $rule;
        }

        $defaultCountries = new ReflectionClass(Phone::class)->getStaticPropertyValue('defaultCountries');

        return 'phone:' . implode(',', array_filter([...$defaultCountries, ...$parameters]));
    }
}
