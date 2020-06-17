<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\OfferAttachment;
use Illuminate\Http\Request;

class OfferAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers_attachments = OfferAttachment::all();

        if (isset($offers_attachments))
            return response([
                'status' => 'success',
                'data' => $offers_attachments,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => "Nie znaleziono powiązań!"
            ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vallidatedData  = $request->validate([
            'odder_id' => 'required',
            'attachment_id' => 'required',
        ]);

        $offer_attachment = new OfferAttachment;
        
        $offer_attachment->odder_id = $request->input('odder_id');
        $offer_attachment->attachment_id = $request->input('attachment_id');

        if($offer_attachment->save())
        {
            return response([
                'status' => 'success',
                'data' => $offer_attachment,
                'message' => null
            ], Response::HTTP_OK);
        } else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Can not create relation!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OfferAttachment  $offerAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(OfferAttachment $offerAttachment)
    {
        $offer_attachment = OfferAttachment::find($id);

        if (isset($offer_attachment))
            return response($offer_attachment, Response::HTTP_OK);
        else
            return response("Relation not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OfferAttachment  $offerAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(OfferAttachment $offerAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OfferAttachment  $offerAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfferAttachment $offerAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OfferAttachment  $offerAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfferAttachment $offerAttachment)
    {
        $offer_attachment = OfferAttachment::find($id);

        if ($offer_attachment->delete())
            return response("Relation has been deleted!", Response::HTTP_OK);
        else
            return response("Relation has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
