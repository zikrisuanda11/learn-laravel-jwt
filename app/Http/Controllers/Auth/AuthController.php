<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function __construct() {
    //     $this->middleware('auth:api', ['except' => ['login','register']]);
    // }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credential = $request->only('email', 'password');

        $token = Auth::attempt($credential);

        if(!$token){
            return response()->json([
                'message' => 'unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'message' => 'success login',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = Auth::login($user);

        return response()->json([
            'message' => 'success register',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'success logout'
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'message' => 'success refresh',
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer'
            ]
        ]);
    }
}
