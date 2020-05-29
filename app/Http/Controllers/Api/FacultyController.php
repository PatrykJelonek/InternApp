<?php

namespace App\Http\Controllers\Api;

use App\Faculty;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $faculties = Faculty::all();

        if (isset($faculties))
            return response($faculties, Response::HTTP_OK);
        else
            return response("Facullties not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Get fields of specific faculty
     *
     * @param $id
     * @return Response
     */
    public function facultyFields($id)
    {
        $faculties = Faculty::find($id);

        if (isset($faculties->fields))
            return response([
                'status' => 'success',
                'data' => $faculties->fields,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Nie znaleziono!'
            ], Response::HTTP_NOT_FOUND);
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
        $faculty = new Faculty;

        $faculty->name = $request->input("name");
        $faculty->created_at = date('Y-m-d H:i:s');
        $faculty->updated_at = date('Y-m-d H:i:s');

        if ($faculty->save())
            return response($faculty, Response::HTTP_CREATED);
        else
            return response("Faculty has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param Faculty $faculty
     * @return Response
     */
    public function show(Faculty $faculty)
    {
        $faculty = Faculty::find($id);

        if (isset($faculty))
            return response($faculty, Response::HTTP_OK);
        else
            return response("Faculty not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Faculty $faculty
     * @return Response
     */
    public function edit(Faculty $faculty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Faculty $faculty
     * @return Response
     */
    public function update(Request $request)
    {
        $faculty = Faculty::find($request->input("id"));

        if (isset($faculty)) {
            $faculty->name = $request->input("name");
            $faculty->updated_at = date('Y-m-d H:i:s');

            if ($faculty->save())
                return response($faculty, Response::HTTP_OK);
        }

        return response("The faculty has not been updated!", Response::HTTP_NOT_MODIFIED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Response
     */
    public function destroy($id)
    {
        $faculty = Faculty::find($id);

        if ($faculty->delete())
            return response("The faculty has been deleted!", Response::HTTP_OK);
        else
            return response("The faculty has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
