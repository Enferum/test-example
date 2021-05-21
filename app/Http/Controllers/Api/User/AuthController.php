<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCredentialRequest;

class AuthController extends Controller
{
    public function login(UserCredentialRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return response(['Invalid login credentials'], 403);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response([
            'user' => auth()->user(),
            'accessToken' => $accessToken
        ]);
    }
}
