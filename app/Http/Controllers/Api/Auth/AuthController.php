<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!$token = auth()->attempt(['email' => $request->input("email"), 'password' => $request->input('password'), 'user_status_id' => 1])) {
            return response('User has not been authenticated!', Response::HTTP_UNAUTHORIZED);
        }

        $userInformation = User::with(['roles'])->where('email', $request->input("email"))->first();
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'user' => $userInformation
        ], Response::HTTP_OK);
    }

    public function me()
    {
        $user = User::with(['roles'])->find(auth()->id());
        return response([
            'status' => 'success',
            'data' => $user,
            'message' => null
        ], Response::HTTP_OK);
    }

    public function refresh()
    {
        try{
            $newToken = auth()->refresh();
        } catch(TokenInvalidException $e)
        {
            return response(['error' => $e], Response::HTTP_UNAUTHORIZED);
        }

        return response(['token' => $newToken], Response::HTTP_OK);
    }

    public function logout()
    {
        try{
            auth()->logout();
        } catch(JWTException $e)
        {
            return response(['error' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }
}
