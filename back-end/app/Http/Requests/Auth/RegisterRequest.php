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
            'name'     => 'required|string|max:50',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
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
            'name.required'     => 'O campo :attribute é obrigatório.',
            'email.required'    => 'O campo :attribute é obrigatório.',
            'email.email'       => 'O campo :attribute deve ser um endereço de e-mail válido.',
            'email.unique'      => 'O :attribute já está em uso.',
            'password.required' => 'O campo :attribute é obrigatório.',
            'password.min'      => 'A :attribute deve ter pelo menos :min caracteres.',
            'password.confirmed'=> 'A confirmação da :attribute não corresponde.',
        ];
    }
}
