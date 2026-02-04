<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|min:5|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username is required.',
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
            'username.min' => 'Username must be at least 5 characters long.',
            'username.max' => 'Username must not exceed 50 characters.',
            'username.unique' => 'Username is already taken.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'Email is already registered.',
            'password.min' => 'Password must be at least 5 characters long.',
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
