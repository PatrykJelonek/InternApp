<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\OfferStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offerStatuses = OfferStatus::all();

        if (isset($offerStatuses))
            return response($offerStatuses, Response::HTTP_OK);
        else
            return response("Offer statuses not found!", Response::HTTP_NOT_FOUND);
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
        $offerStatus = new OfferStatus;

        if (isset($offerStatus)) {
            $offerStatus->name = $request->input("name");
            $offerStatus->description = $request->input("description");
            $offerStatus->created_at = date('Y-m-d H:i:s');
            $offerStatus->updated_at = date('Y-m-d H:i:s');

            if ($offerStatus->save())
                return response($offerStatus, Response::HTTP_OK);
        }

        return response("Offer status has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offerStatus = OfferStatus::find($id);

        if (isset($offerStatus))
            return response($offerStatus, Response::HTTP_OK);
        else
            return response("Offer status not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OfferStatus  $offerStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(OfferStatus $offerStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OfferStatus  $offerStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $offerStatus = OfferStatus::find($request->input("id"));

        if (isset($offerStatus)) {
            $offerStatus->name = $request->input("name");
            $offerStatus->description = $request->input("description");
            $offerStatus->updated_at = date('Y-m-d H:i:s');

            if ($offerStatus->save())
                return response($offerStatus, Response::HTTP_OK);
        }

        return response("Offer status not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offerStatus = OfferStatus::find($id);

        if ($offerStatus->delete())
            return response("Offer status has been deleted!", Response::HTTP_OK);
        else
            return response("Offer status has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
