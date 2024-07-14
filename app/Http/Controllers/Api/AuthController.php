<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        // Check if the request has the required fields
        if (!$request->has('email') || !$request->has('password')) {
            return response()->json(['message' => 'Request body is missing email or password'], 400);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Check for an existing active token
            $existingToken = $user->tokens()->where('name', 'auth_token')->first();
                        
            if ($existingToken) {
                $token = $existingToken->token;
            } else {
                $token = $user->createToken('auth_token')->plainTextToken;
            }

            // $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    /**
     * Handle user logout from single device.
     */
    // public function logout(Request $request)
    // {
    //     $user = $request->user();
    
    //     if ($user) {
    //         $tokenId = $request->bearerToken();

    //         $user->tokens()->where('id', $tokenId->id)->delete();
    
    //         return response()->json(['message' => 'Logged out from this device.']);
    //     }
    
    //     return response()->json(['message' => 'User not authenticated.'], 401);
    // }
    
    /**
     * Handle user logout from all devices.
     */
    // public function logoutAll(Request $request)
    // {
    //     $user = $request->user();
    
    //     if ($user) {
    //         $user->tokens()->delete();
    
    //         return response()->json(['message' => 'Logged out from all devices.']);
    //     }
    
    //     return response()->json(['message' => 'User not authenticated.'], 401);
    // }

    /**
     * Get authenticated user.
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
