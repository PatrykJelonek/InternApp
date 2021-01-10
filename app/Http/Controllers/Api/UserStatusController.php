<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $a = true;

        if($a)
            return response(UserStatus::all(), Response::HTTP_OK);
        else
            return response('You have not access',Response::HTTP_NOT_FOUND);
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
        $userStatus = new UserStatus;
        $userStatus->name = $request->input('name');
        $userStatus->description = $request->input('description');
        $userStatus->created_at = date('Y-m-d H:i:s');
        $userStatus->updated_at = date('Y-m-d H:i:s');

        if($userStatus->save())
            return response($userStatus, Response::HTTP_CREATED);
        else
            return response('Error', Response::HTTP_CONFLICT);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $userStatus = User::find($request->input("id"));

        if (isset($userStatus)) {
            $userStatus->name = $request->input("name");
            $userStatus->description = $request->input("description");
            $userStatus->updated_at = date('Y-m-d H:i:s');

            if ($userStatus->save())
                return response($userStatus, Response::HTTP_OK);
        }

        return response("User status has not updated!", Response::HTTP_NOT_MODIFIED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $userStatus = UserStatus::find($id);

        if($userStatus->delete())
            return response('Item deleted', Response::HTTP_OK);
        else
            return response('Item not deleted', Response::HTTP_CONFLICT);
    }
}
