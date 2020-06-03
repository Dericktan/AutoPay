<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CounterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:vendors,name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.unique' => 'Vendor with this name is already exist, please input another name'
        ];
    }

    protected function failedValidation(Validator $validator) {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            response()->json(array("errors" => $errors, "message" => "Data is not valid!"), 400)
        );
    }
}