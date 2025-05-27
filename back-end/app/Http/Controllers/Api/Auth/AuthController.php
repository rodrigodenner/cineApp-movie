<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        $token = Auth::login($user);

        return response()->json([
            'user'  => $user,
            'token' => $token
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        return response()->json([
            'user'  => Auth::user(),
            'token' => Auth::token()
        ]);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = Auth::user();

        $user->update($request->validated());

        return response()->json($user);
    }

    public function destroy()
    {
        Auth::user()->delete();

        return response()->json(['message' => 'Conta excluída com sucesso.']);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Deslogado com sucesso.']);
    }
}
