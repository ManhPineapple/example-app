<?php

namespace App\Http\Controllers\userController;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ], 400);
        }
    
        $validatedData = $validator->validated();
    
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
    
        return response()->json([
            'status' => 200,
            'message' => 'User registered successfully',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    public function login(Request $request) {
        $user = User::where('email',  $request->email)->first();
          if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Username or password incorrect',
                'data' => null
            ]);
        }

        $user->tokens()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'User logged in successfully',
            'data' => [
                'name' => $user->name,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ]
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'status' => 200,
                'message' => 'User logged out successfully',
                'data' => null
            ]);
  }
}