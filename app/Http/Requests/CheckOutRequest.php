<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CheckOutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'card_code' => 'required|exists:users,card_code',
            'total' => 'required|integer',
            'carts' => 'required|array',
            'carts.*.product_id' => 'required|exists:products,id',
            'carts.*.quantity' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'card_code.required' => 'Card code is required',
            'card_code.exists' => 'Card code is not valid',
            'total.required' => 'Total is required',
            'total.integer' => 'Total value must be a number',
            'carts.required' => 'Carts is required',
            'carts.array' => 'Carts value must be an array'
        ];
    }

    protected function failedValidation(Validator $validator) {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            response()->json(array("errors" => $errors, "message" => "Data is not valid!"), 400)
        );
    }
}