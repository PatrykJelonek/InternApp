<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();

        if (isset($permissions))
            return response($permissions, Response::HTTP_OK);
        else
            return response("Permissions not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = new Permission;

        if (isset($permission)) {
            $permission->name = $request->input("name");
            $permission->display_name = $request->input("display name");
            $permission->description = $request->input("description");
            $permission->created_at = date('Y-m-d H:i:s');
            $permission->updated_at = date('Y-m-d H:i:s');

            if ($permission->save())
                return response($permission, Response::HTTP_OK);
        }

        return response("Permission has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::find($id);

        if (isset($permission))
            return response($permission, Response::HTTP_OK);
        else
            return response("Permission not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $permission = Permission::find($request->input("id"));

        if (isset($permission)) {
            $permission->name = $request->input("name");
            $permission->display_name = $request->input("display name");
            $permission->description = $request->input("description");
            $permission->updated_at = date('Y-m-d H:i:s');

            if ($permission->save())
                return response($permission, Response::HTTP_OK);
        }

        return response("Permission not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);

        if ($permission->delete())
            return response("Permission has been deleted!", Response::HTTP_OK);
        else
            return response("Permission has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
