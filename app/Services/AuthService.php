<?php

namespace App\Services;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthService
{
    /**
     * Logs in a user and creates an access token.
     *
     * @param array $credentials
     * @return array
     * @throws AuthenticationException
     */
    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        $user = Auth::user();

        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return [
            'success' => true,
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Logs out the user, revoking the current token.
     *
     * @return array
     */
    public function logout(): array
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return [
            'success' => true,
            'message' => 'Logged out successfully.',
        ];
    }

    /**
     * Method to check if a user is authenticated.
     *
     * @return array
     */
    public function check(): array
    {
        $user = Auth::user();

        return [
            'success' => true,
            'user' => $user,
        ];
    }
}
