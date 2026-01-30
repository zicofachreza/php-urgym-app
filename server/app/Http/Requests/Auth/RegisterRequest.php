<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

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
}
