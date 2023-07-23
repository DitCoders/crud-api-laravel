<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthC extends Controller
{
    public function register(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'email' => 'required|unique:users',
            'password' => 'required|min:8'
        ]);
        if ($validasi->fails()) {
            return response()->json($validasi->errors());
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'email' => $request->email,
            'token' => $token,
            'type' => 'Bearer'
        ]);
    }
    public function login(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:8'
        ]);
        if ($validasi->fails()) {
            return response()->json($validasi->errors());
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'email' => $request->email,
            'token' => $token,
            'type' => 'Bearer'
        ]);
    }
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'berhasil logout'
        ]);
    }
}
