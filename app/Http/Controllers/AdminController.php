<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class AdminController extends Controller
{
    public function login(LoginRequest $request){
        $data = $request->validated();
        if(!auth()->attempt($request->all())){
            return response()->json([
                'data' => [],
                'message' => 'Please check your email or password!'
            ], 401);
        }
        
        // Create Passport token
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $data = [
            'user' => auth()->user(),
            'access_token' => $accessToken
        ];

        return response()->json([
            'data' => $data,
            'message' => 'Sucessfully logged in'
            ]);
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'message' => 'Sucessfully logged out!',
            'data' => []
        ]);
    }
}
