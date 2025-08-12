<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:20',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()]
        ];
    }
}
