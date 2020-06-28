<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Specialization;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $specializations = Specialization::all();

        if (isset($specializations))
            return response([
                'status' => 'success',
                'data' => $specializations,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Nie znaleziono żadnych specializacji'
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
        $specialization = new Specialization;

        $specialization->name = $request->input("name");
        $specialization->description = $request->input("description");
        $specialization->created_at = date('Y-m-d H:i:s');
        $specialization->updated_at = date('Y-m-d H:i:s');

        if ($specialization->save())
            return response($specialization, Response::HTTP_OK);
        else
            return response("Specialization has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param Specialization $specialization
     * @return Response
     */
    public function show(Specialization $specialization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Specialization $specialization
     * @return Response
     */
    public function edit(Specialization $specialization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Specialization $specialization
     * @return Response
     */
    public function update(Request $request)
    {
        $specialization = Specialization::find($request->input("id"));

        if (isset($specialization)) {
            $specialization->name = $request->input("name");
            $specialization->description = $request->input("description");
            $specialization->updated_at = date('Y-m-d H:i:s');

            if ($specialization->save())
                return response($specialization, Response::HTTP_OK);
        }

        return response("Specialization has not been updated!", Response::HTTP_NOT_MODIFIED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Response
     */
    public function destroy($id)
    {
        $specialization = Specialization::find($id);

        if ($specialization->delete())
            return response("Specialization has been deleted!", Response::HTTP_OK);
        else
            return response("Specialization has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
