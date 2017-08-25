<?php

namespace Modules\ModuleControl\Http\Controllers;

use JWTAuth;
use Illuminate\Routing\Controller;
use Modules\ModuleControl\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (! $token = JWTAuth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Usuario e/ou senha invalidos'], 401);
        }

        return response()->json(compact('token'));
    }
}
