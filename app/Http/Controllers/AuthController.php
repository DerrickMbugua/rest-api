<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request, Response $response)
    {
        Log::info("Hit");
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|max:100|email',
            'password' => 'required|confirmed|string|max:100',
        ]);
        Log::info("Validate");
        
        if ($validator->fails()) {
            return response("ValidationFailed");
        }

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Log::info("User");
        $token = $user->createToken('appToken')->plainTextToken;
        Log::info("Token");
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request, Response $response)
    {
        Log::info("Login");
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:100|email',
            'password' => 'required|string|max:100',
        ]);

        Log::info("Validate");

        if ($validator->fails()) {
            return response("Validation Failed");
        }

        //check email
        $user = User::where('email', $request->email)->first();

        Log::info("Find user by email");

        //check password
        if (!$user || !Hash::check($request->password, $user->password) ) {
            return response("Bad credentials", 401);
        }

        Log::info("Check password");

        $token = $user->createToken('appToken')->plainTextToken;

        Log::info("Token");

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        Log::info("Hit");
        auth()->user()->tokens()->delete();

        return "Logged out";
    }
}
