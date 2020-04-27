<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\InternshipStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InternshipStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $internshipStatuses = IntershipStatus::all();

        if (isset($internshipStatuses))
            return response($internshipStatuses, Response::HTTP_OK);
        else
            return response("Internship statuses not found!", Response::HTTP_NOT_FOUND);
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
        $internshipStatus = new InternshipStatus;

        if (isset($internshipStatus)) {
            $internshipStatus->name = $request->input("name");
            $internshipStatus->created_at = date('Y-m-d H:i:s');
        

            if ($internshipStatus->save())
                return response($internshipStatus, Response::HTTP_OK);
        }

        return response("Internship status has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $internshipStatus = InternshipStatus::find($id);

        if (isset($internshipStatus))
            return response($internshipStatus, Response::HTTP_OK);
        else
            return response("Internship status not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InternshipStatus  $internshipStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(InternshipStatus $internshipStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InternshipStatus  $internshipStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $internshipStatus = InternshipStatus::find($request->input("id"));

        if (isset($internshipStatus)) {
            $internshipStatus->name = $request->input("name");

            if ($internshipStatus->save())
                return response($internshipStatus, Response::HTTP_OK);
        }

        return response("Internship status not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InternshipStatus  $internshipStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $internshipStatus = InternshipStatus::find($id);

        if ($internshipStatus->delete())
            return response("Internship status has been deleted!", Response::HTTP_OK);
        else
            return response("Internship status has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
