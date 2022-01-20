<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Repository\Auth\EloquentAuthRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    protected EloquentAuthRepository $eloquentAuth;

    public function __construct(EloquentAuthRepository $eloquentAuth)
    {
        $this->eloquentAuth = $eloquentAuth;
    }

    /**
     * User Login
     *
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request)
    {
        $credentials = request(['email', 'password', 'remember_me']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'These credentials do not match our records.', 'errors' => []], 403);
        }
        return $this->eloquentAuth->login($request);
    }

    /**
     * User register
     *
     * @param AuthRegisterRequest $request
     * @return JsonResponse
     */
    public function register(AuthRegisterRequest $request)
    {
        try {
            return $this->eloquentAuth->register($request);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    /**
     * User Logout
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $this->eloquentAuth->logout($request);
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
