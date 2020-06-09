<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UniversityType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UniversityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $universityTypes = UniversityType::all();

        if (isset($universityTypes))
            return response([
                'status' => 'success',
                'data' => $universityTypes,
                'message' => null
            ], Response::HTTP_OK);
        else
        return response([
            'status' => 'error',
            'data' => null,
            'message' => error
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
        $universityType = new UniversityType;

        $universityType->name = $request->input("name");
        $universityType->description = $request->input("description");
        $universityType->created_at = date('Y-m-d H:i:s');
        $universityType->updated_at = date('Y-m-d H:i:s');

        if ($universityType->save())
            return response($universityType, Response::HTTP_OK);
        else
            return response("University type has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Response
     */
    public function show($id)
    {
        $universityType = UniversityType::find($id);

        if (isset($universityType))
            return response($universityType, Response::HTTP_OK);
        else
            return response("University type not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param UniversityType $universityType
     * @return Response
     */
    public function edit(UniversityType $universityType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param UniversityType $universityType
     * @return Response
     */
    public function update(Request $request)
    {
        $universityType = UniversityType::find($request->input("id"));

        if (isset($universityType)) {
            $universityType->name = $request->input("name");
            $universityType->description = $request->input("description");
            $universityType->updated_at = date('Y-m-d H:i:s');

            if ($universityType->save())
                return response($universityType, Response::HTTP_OK);
        }

        return response("University type has not been updated!", Response::HTTP_NOT_MODIFIED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Response
     */
    public function destroy($id)
    {
        $universityType = UniversityType::find($id);

        if ($universityType->delete())
            return response("University type has been deleted!", Response::HTTP_OK);
        else
            return response("University typ has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
