<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\AuthForgotPasswordRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use App\Notifications\UserResetPasswordEmail;
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
    private const REQUEST_FIELD_EMAIL = 'email';
    private const REQUEST_FIELD_PASSWORD = 'password';
    private const USER_STATUS_ACTIVE = 1;
    private const TOKEN_TYPE_BEARER = 'bearer';

    public function login(AuthLoginRequest $request)
    {
        $token = auth()->attempt(
            [
                'email' => $request->input(self::REQUEST_FIELD_EMAIL),
                'password' => $request->input(self::REQUEST_FIELD_PASSWORD),
                'user_status_id' => self::USER_STATUS_ACTIVE,
            ]);

        if (!$token) {
            return response('Użytkownik nie został uwierzytelniony!', Response::HTTP_UNAUTHORIZED);
        }

        $userInformation = User::with(['roles', 'permissions','universities','companies'])
            ->where('email', $request->input(self::REQUEST_FIELD_EMAIL))
            ->first();

        return response()->json([
            'token' => $token,
            'token_type' => self::TOKEN_TYPE_BEARER,
            'user' => $userInformation
        ], Response::HTTP_OK);
    }

    public function me()
    {
        $user = User::with(['roles', 'permissions', 'universities','companies'])->find(auth()->id());
        return response([
            'status' => 'success',
            'data' => $user,
            'message' => null
        ], Response::HTTP_OK);
    }

    public function refresh()
    {
        try {
            $newToken = auth()->refresh();
        } catch (TokenInvalidException $e) {
            return response(['error' => $e], Response::HTTP_UNAUTHORIZED);
        }

        return response(['token' => $newToken], Response::HTTP_OK);
    }

    public function logout()
    {
        try {
            auth()->logout();
        } catch (JWTException $e) {
            return response(['error' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function forgotPassword(AuthForgotPasswordRequest $request)
    {
        $user = User::where(['email' => $request->only('email')])->first();

        if(!empty($user) && !empty($user->password_reset_token)) {
            $user->notify(new UserResetPasswordEmail($user));
        }

        return response(null, Response::HTTP_OK);
    }
}
