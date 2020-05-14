<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allUsers = User::all();

        if(isset($allUsers))
            return response($allUsers, Response::HTTP_OK);
        else
            return response("Error", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|max:64',
            'lastName' => 'required|max:64',
            'phone' => 'required|max:16',
            'email' => 'required|unique:users|max:64',
            'password' => 'required|max:255',
        ]);

        $user = new User;

        //Personal Data
        $user->first_name = $request->input("firstName");
        $user->last_name = $request->input("lastName");
        $user->phone_number = $request->input("phone");

        //Login Data
        $user->email = $request->input("email");
        $user->password_hash = Hash::make($request->input("password"));
        $user->password_reset_token  = Str::random(64);
        $user->remember_token = "remember_token";

        //Account Data
        $user->user_status_id = 1;

        //Dates
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');

        if ($user->save())
            return response("Account has been created!", Response::HTTP_CREATED);
        else
            return response("Account has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }
}
