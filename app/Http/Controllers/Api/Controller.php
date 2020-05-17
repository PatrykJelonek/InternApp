<?php

namespace App\Http\Api\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        auth()->setDefaultDriver('api');
    }

    public function authUser($roles)
    {
        try{
            $user = auth()->userOrFail();

            if(count($roles) > 0)
                foreach ($roles as $role)
                    if(!$user->hasRole($role))
                        throw new UserNotDefinedException("User not definded!");
                    else
                        break;

        } catch(UserNotDefinedException $e) { return response(['error' => $e], Response::HTTP_UNAUTHORIZED); }

        return $user;
    }
}

