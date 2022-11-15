<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $validated = $request->all();

        $status = 0;

        $validated['password'] = Hash::make($validated['password']);

        $data = User::create($validated);
 
        if($data) $status = 1;

        return response()->json([
            "status" => $status,
            "data" => $data
        ]);
    }

    public function profile()
    {
        return response()->json([
            'data' => auth()->user(),
            'status' => 1,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->safe()->only(['username', 'password']);

        $data = User::where('username', $validated['username'])->first();

        if ( !$data || !Hash::check($validated['password'], $data->password) ) {

            return response()->json([
                'message' => 'Invalid login details',
            ], 401);

        }
        $data->tokens()->delete();

        $token = $data->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ]);
        
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();

        return response()->json([
            'message' => 'user logged out',
            'status' => 1
        ]);

    }

}