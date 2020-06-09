<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Offer;
use App\OfferStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
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
        $validatedData = $request->validate([
            'companyId' => 'required',
            'name' => 'required|max:128',
            'placesNumber' => 'required',
            'program' => 'required',
            'schedule' => 'required',
            'offerCategoryId' => 'required',
            'companySupervisorId' => 'required',
        ], Offer::messages());

        $offer = new Offer;
        $offer_status = OfferStatus::where('name', 'new')->get();

        $offer->company_id = $request->input('companyId');
        $offer->name= $request->input('name');
        $offer->places_number = $request->input('placesNumber');
        $offer->program = $request->input('program');
        $offer->schedule = $request->input('schedule');
        $offer->offer_category_id = $request->input('offerCategoryId');
        $offer->company_supervisor_id = $request->input('companySupervisorId');
        $offer->interview = $request->input('interivew') == true ? 1 : 0;
        $offer->user_id = auth()->id();
        $offer->updated_at = date('Y-m-d H:i:s');
        $offer->created_at = date('Y-m-d H:i:s');
        $offer->offer_status_id = $offer_status[0]->id;

        if($offer->save())
        {
            return response([
                'status' => 'success',
                'data' => $offer,
                'message' => null
            ], Response::HTTP_OK);
        } else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Nie udało się utworzyć oferty!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Response
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
     * @param Offer $offer
     * @return Response
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Offer $offer
     * @return Response
     */
    public function update(Request $request, Offer $offer)
    {
        //TODO: UPDATE METHOD!!
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Offer $offer
     * @return Response
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
