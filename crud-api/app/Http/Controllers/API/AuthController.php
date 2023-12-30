<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil',
                'user' => $user,
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'Username atau password salah'], 401);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'full_name' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        return response()->json(['message' => 'Pendaftaran berhasil', 'user' => $user], 201);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();
    
        if ($token) {
            $token->delete();
        }
    
        return response()->json(['message' => 'Successfully logged out']);
    }
}
