<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Resources\Auth\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\RegisterRequest;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

#[Group("Auth", "Autenticación de un usuario en el API")]
class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "password" => Hash::make($request->input("password"))
        ]);

        return response()->json([
            'message' => 'Usuario creado', 'user' => $user
        ], Response::HTTP_CREATED);
    }

    /**
     * Get the authenticated User.
     * @authenticated
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(new UserResource(auth()->user()));
    }

    /**
     * Log the user out (Invalidate the token).
     * @authenticated
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     * @authenticated
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        try {
            return $this->respondWithToken(auth()->refresh());
        } catch (ExpiredException | TokenBlacklistedException | TokenInvalidException | Exception $e) {
            Log::error('Invalid token' . $e->getMessage());
            return response()->json(['error' => 'Invalid token' . $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], Response::HTTP_OK);
    }
}
