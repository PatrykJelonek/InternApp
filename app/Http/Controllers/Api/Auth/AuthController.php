<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

/**
 * @group Authorization
 * APIs methods to user authorization
 *
 * Class AuthController
 * @package App\Http\Controllers\Api\Auth
 */
class AuthController extends Controller
{

    /**
     * Login
     * Login into system by email and password.
     * @bodyParam email string required Account email used in system. Example: admin@example.com
     * @bodyParam password string required Account password used in system. Example: password
     *
     * @response {
     *  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTYwOTEwMTM2OSwibmJmIjoxNjA5MTAxMzY5LCJqdGkiOiJkR0hlRU5vaXVTaTg3cVZwIiwic3ViI233oxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.rA0BzIl4WpaOr1iT22mHHnWBcQw_xJ8EiIJwQ390I7Y",
     *  "token_type": "bearer",
     *  "user": {null}
     * }
     *
     * @response 401 {
     *  "message": "User has not been authenticated!"
     * }
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!$token = auth()->attempt(['email' => $request->input("email"), 'password' => $request->input('password'), 'user_status_id' => 1])) {
            return response('User has not been authenticated!', Response::HTTP_UNAUTHORIZED);
        }

        $userInformation = User::with(['roles', 'permissions'])->where('email', $request->input("email"))->first();
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'user' => $userInformation
        ], Response::HTTP_OK);
    }

    /**
     * User Information
     * Current logged user information.
     * @authenticated
     *
     * @response {
     *  "status": "success",
     *  "data": {null},
     *  "message": null
     * }
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function me()
    {
        $user = User::with(['roles', 'permissions'])->find(auth()->id());
        return response([
            'status' => 'success',
            'data' => $user,
            'message' => null
        ], Response::HTTP_OK);
    }

    /**
     * Refresh Token
     * Refresh current logged user token.
     * @authenticated
     * @response {
     *  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTYwOTEwMTM2OSwibmJmIjoxNjA5MTAxMzY5LCJqdGkiOiJkR0hlRU5vaXVTaTg3cVZwIiwic3ViI233oxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.rA0BzIl4WpaOr1iT22mHHnWBcQw_xJ8EiIJwQ390I7Y",
     * }
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function refresh()
    {
        try {
            $newToken = auth()->refresh();
        } catch (TokenInvalidException $e) {
            return response(['error' => $e], Response::HTTP_UNAUTHORIZED);
        }

        return response(['token' => $newToken], Response::HTTP_OK);
    }

    /**
     * Logout
     * Logout current logged user from system.
     * @authenticated
     *
     *
     * @response {
     *  "message": "Successfully logged out"
     * }
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response
     */
    public function logout()
    {
        try {
            auth()->logout();
        } catch (JWTException $e) {
            return response(['error' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }
}
