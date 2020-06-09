<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::all();

        if (isset($offers))
            return response($offers, Response::HTTP_OK);
        else
            return response("Offers not found!", Response::HTTP_NOT_FOUND);
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
        $validatedData = $request->validate([
            'companyId' => 'required',
            'name' => 'required|max:128',
            'placesNumber' => 'required',
            'program' => 'required',
            'schedule' => 'required',
            'offerCategoryId' => 'required',
            'companySupervisorId' => 'required',
            'interview' => 'required',
        ], Offer::messages());

        $offer = new Offer;

        $offer->company_id = $request->input('companyId');
        $offer->name= $request->input('name');
        $offer->places_number = $request->input('placesNumber');
        $offer->program = $request->input('program');
        $offer->schedule = $request->input('schedule');
        $offer->offer_category_id = $request->input('offerCategoryId');
        $offer->company_supervisor_id = $request->input('companySupervisorId');
        $offer->interview = $request->input('interivew');
        $offer->user_id = auth()->id();
        $offer->updated_at = date('Y-m-d H:i:s');
        $offer->created_at = date('Y-m-d H:i:s');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = Offer::find($id);

        if (isset($offer))
            return response($offer, Response::HTTP_OK);
        else
            return response("Offer not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //TODO: UPDATE METHOD!!
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $offer = Offer::find($id);

        if ($offer->delete())
            return response("Offer has been deleted!", Response::HTTP_OK);
        else
            return response("Offer has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
