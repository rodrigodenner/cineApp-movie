<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Auth"},
     *     summary="Registrar novo usuário",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="Rodrigo Denner"),
     *             @OA\Property(property="email", type="string", format="email", example="rodrigo@email.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Usuário registrado com sucesso")
     * )
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        $token = Auth::login($user);

        return response()->json([
            'user'  => new UserResource($user),
            'token' => $token
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Login de usuário",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="rodrigo@email.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login realizado com sucesso"),
     *     @OA\Response(response=401, description="Credenciais inválidas")
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $token = Auth::attempt($credentials);

        if (!$token) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        return response()->json([
            'user'  => new UserResource(Auth::user()),
            'token' => $token
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/auth/user",
     *     tags={"Auth"},
     *     summary="Atualizar dados do usuário autenticado",
     *     security={{"Bearer":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Novo Nome"),
     *             @OA\Property(property="email", type="string", format="email", example="novo@email.com"),
     *             @OA\Property(property="password", type="string", format="password", example="novaSenha123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="novaSenha123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Usuário atualizado")
     * )
     */
    public function update(UpdateUserRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return response()->json(new UserResource($user));
    }

    /**
     * @OA\Delete(
     *     path="/api/auth/user",
     *     tags={"Auth"},
     *     summary="Excluir conta do usuário autenticado",
     *     security={{"Bearer":{}}},
     *     @OA\Response(response=200, description="Conta excluída com sucesso")
     * )
     */
    public function destroy()
    {
        Auth::user()->delete();

        return response()->json(['message' => 'Conta excluída com sucesso.']);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     summary="Logout do usuário autenticado",
     *     security={{"Bearer":{}}},
     *     @OA\Response(response=200, description="Logout realizado com sucesso")
     * )
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Deslogado com sucesso.']);
    }
}
