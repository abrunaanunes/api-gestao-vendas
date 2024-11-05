<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        return response()->json($this->authService->login($credentials));
    }

    public function logout()
    {
        return response()->json($this->authService->logout());
    }

    public function check()
    {
        return response()->json($this->authService->check());
    }
}

