<?php

namespace App\Http\Controllers\Api;

use App\Http\Api\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class DebugController extends Controller
{
    public function index()
    {
        try{
            $user = auth()->userOrFail();


        } catch(UserNotDefinedException $e)
        {
            return response(['error' => 'asd']);
        }
    }
}
