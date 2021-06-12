<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_no' => 'required',
            'password' => 'required|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'User created successfuly',
        ]);
    }

    public function profile()
    {
        $userData = auth()->user();
        
        return response()->json([
            'status' => 1,
            'message' => 'Got user data successfully',
            'data' => $userData,
        ]);
    } 

    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verify user + token
        $token = auth()->attempt(['email' => $request->email, 'password' => $request->password]);

        if(!$token) {
            // Send response
            return response()->json([
                'status' => 0,
                'message' => 'Invalid credentials'
            ]);
        }
        
        // Send response
        return response()->json([
            'status' => 1,
            'message' => 'Logged in successfully',
            'token' => $token
        ]);

    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 1,
            'message' => 'User logged out',
        ]);
    }
   
}
