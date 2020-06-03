<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CardRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'card_code' => 'required|exists:users,card_code',
            'password' => 'sometimes'
        ];
    }

    public function messages()
    {
        return [
            'card_code.required' => 'Card code is required',
        ];
    }

    protected function failedValidation(Validator $validator) {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            response()->json(array("errors" => $errors, "message" => "Data is not valid!"), 400)
        );
    }
}