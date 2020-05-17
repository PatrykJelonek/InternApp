<?php

namespace App\Http\Controllers\Api;

//use App\Http\Controllers\Controller;
use App\Http\Api\Controllers\Controller;
use App\Role;
use App\University;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();

        if(!$user->hasRole('admin'))
           return response([
               'status' => 'error',
               'data' => null,
               'message' => 'Nie posiadasz uprawnień do tego zasobu!'
           ], Response::HTTP_UNAUTHORIZED);

        $universities = University::all();

        if (isset($universities))
            return response([
                'status' => 'success',
                'data' => $universities,
                'message' => null
            ], Response::HTTP_OK);
        else
            return \response("Universities not found!", Response::HTTP_NOT_FOUND);
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
        //TODO: Create method to create university
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Response
     */
    public function show($id)
    {
        $university = University::find($id);

        if (isset($university))
            return response($university, Response::HTTP_OK);
        else
            return reponse("University not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param University $university
     * @return Response
     */
    public function edit(University $university)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param University $university
     * @return Response
     */
    public function update(Request $request, University $university)
    {
        //TODO: Create method to update University
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Response
     */
    public function destroy($id)
    {
        $university = University::find($id);

        if ($university->delete())
            return response("University has been deleted!", Response::HTTP_OK);
        else
            return response("University has not been deleted", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
