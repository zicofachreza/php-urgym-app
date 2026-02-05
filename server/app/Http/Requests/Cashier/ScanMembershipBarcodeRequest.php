<?php

namespace App\Http\Requests\Cashier;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ScanMembershipBarcodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'barcode' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'barcode.required' => 'Barcode is required.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422)
        );
    }
}
