<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Order extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rule = [
            'id' => ['required', 'string'],
            'name' => ['required', 'string'],
            'address' => ['required', 'array'],
            'address.city' => ['required', 'string'],
            'address.district' => ['required', 'string'],
            'address.street' => ['required', 'string'],
            'price' => ['required', 'int', 'min:0'],
            'currency' => ['required', 'string'],
        ];

        return $rule;
    }

    /**
     * 統一回傳JSON較方便測試
     * 
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * 
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * 
     * @return never
     */
    protected function failedValidation(Validator $validator): never
    {
        $data = [
            'message' => 'Field error',
            'errors' => $validator->errors(),
        ];

        $response = response()->json($data, 400);

        throw new HttpResponseException($response);
    }
}
