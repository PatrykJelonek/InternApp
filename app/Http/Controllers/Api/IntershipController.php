<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Intership;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IntershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interships = Intership::all();

        if (isset($interships))
            return response($interships, Response::HTTP_OK);
        else
            return response("Interships not found!", Response::HTTP_NOT_FOUND);
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
        //TODO
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $intership = intership::find($id);

        if (isset($intership))
            return response($intership, Response::HTTP_OK);
        else
            return response("Intership not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Intership  $intership
     * @return \Illuminate\Http\Response
     */
    public function edit(Intership $intership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Intership  $intership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Intership $intership)
    {
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Intership  $intership
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $intership = Intership::find($id);

        if ($intership->delete())
            return response("Intership has been deleted!", Response::HTTP_OK);
        else
            return response("Intership has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
