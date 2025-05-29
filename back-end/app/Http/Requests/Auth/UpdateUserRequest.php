<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'sometimes|string|max:50',
            'email'    => 'sometimes|email|unique:users,email,' . $this->user()->id,
            'password' => 'sometimes|min:6|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            'name'     => 'nome',
            'email'    => 'e-mail',
            'password' => 'senha',
        ];
    }

    public function messages()
    {
        return [
            'password.min'       => 'A :attribute deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'A confirmação da :attribute não corresponde.',
        ];
    }
}
