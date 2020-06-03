<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required',
            'vendor_id' => 'required|exists:vendors,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'quantity.required' => 'Quantity is required',
            'price.required' => 'Price is required',
            'vendor_id.required' => 'Vendor_id is required',
            'vendor_id.exists' => 'Please check your vendor_id',
        ];
    }

    protected function failedValidation(Validator $validator) {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            response()->json(array("errors" => $errors, "message" => "Data is not valid!"), 400)
        );
    }
}
