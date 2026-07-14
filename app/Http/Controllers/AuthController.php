<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        try {
            $token = Auth::guard('api')->login($user);
            if (! $token) {
                return $this->errorResponse('Error al generar el token.', 500);
            }

            return $this->successResponse($this->tokenPayload($user, $token),
                'Usuario registrado exitosamente.',
                201);
        } catch (JWTException $e) {
            return $this->errorResponse('Error al generar el token.', 500);
        }
    }

    public function tokenPayload(User $user, string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => new UserResource($user)
        ];
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]
        );
        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return $this->errorResponse('Credenciales incorrectas.', 401);
        }

        return $this->successResponse(
            $this->tokenPayload(Auth::guard('api')->user(), $token)
        );
    }

    public function me()
    {
        return $this->successResponse(new UserResource(Auth::guard('api')->user()));
    }

    public function logout(): JsonResponse
    {
        Auth::guard('api')->logout();

        return $this->successResponse(null, 'Sesión cerrada exitosamente.');
    }

    public function refresh(): JsonResponse
    {
        $token = Auth::guard('api')->refresh();

        return $this->successResponse(
            $this->tokenPayload(Auth::guard('api')->user(), $token)
        );
    }
}
