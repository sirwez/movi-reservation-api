<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
        
            $user->tokens()->delete();
            $token = $user->createToken('auth_token', ['manager'])->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token, 
                'user' => $user, 
            ], 200);

        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }



    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $token = $user->createToken($request->name, ['manager'])->plainTextToken;
        return response()->json(['message' => 'Registration successful'], 201);
    }

    public function logout(Request $request)
    {
        // Revoga apenas o token atual
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }
}
