<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UserDAL;

class RegisterController extends Controller
{
        public function signup(Request $request)
    {
        // $request['firstName'] = 'pedeo';
        // $request['lastname'] = 'TUMBLER';
        // $request['email'] = 'ped2@gmail.com';
        // $request['password'] = 'admin123';
    
         $user = User::create([
            'firstName' => $request->input('firstName'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);

    }
    public function getEmailByName(Request $request)
    {
        // Validate the request to ensure name parameters are provided
        $request->validate([
            'firstName' => 'required|string',
            'lastname' => 'required|string',
        ]);
    
        // Find the user by first name and last name
        $user = User::where('firstName', $request->input('firstName'))
                    ->where('lastname', $request->input('lastname'))
                    ->first();
    
        // Check if the user was found
        if ($user) {
            return response()->json(['email' => $user->email], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    
   
}
