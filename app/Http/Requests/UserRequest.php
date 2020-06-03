<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'card_code' => 'required|unique:users'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'gender.required' => 'Gender is required',
            'address.required' => 'Address is required',
            'card_code.required' => 'Card code is required'
        ];
    }

    protected function failedValidation(Validator $validator) {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            response()->json(array("errors" => $errors, "message" => "Data is not valid!"), 400)
        );
    }
}
