<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->input("email"), 'password' => $request->input('password'), 'user_status_id' => 1])) {
            $userInformation = User::select('email','first_name','last_name','phone_number')->where('email', $request->input("email"))->first();

            return response($userInformation, Response::HTTP_OK);
        } else
            return response('User has not been authenticated!', Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
