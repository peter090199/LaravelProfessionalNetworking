<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
           // $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                // 'access_token' => $token,
                // 'token_type' => 'Bearer',
                // 'expires_at' => Carbon::now()->addHours(1), // Example expiration time
                'message' => 'Login successful'
            ]);
        }

        return response()->json([
            'message' => 'Cannot Login!'
        ], 401);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }

}
