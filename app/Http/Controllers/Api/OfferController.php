<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeOfferStatusRequest;
use App\Http\Requests\OfferIndexRequest;
use App\Http\Requests\StoreOfferRequest;
use App\Models\Offer;
use App\Models\OfferStatus;
use App\Repositories\OfferRepository;
use App\Services\OfferService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    /**
     * @var OfferService
     */
    private $offerService;

    /**
     * @var OfferRepository
     */
    private $offerRepository;

    /**
     * OfferController constructor.
     *
     * @param OfferService $offerService
     * @param OfferRepository $offerRepository
     */
    public function __construct(OfferService $offerService, OfferRepository $offerRepository)
    {
        $this->offerService = $offerService;
        $this->offerRepository = $offerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param OfferIndexRequest $request
     *
     * @return Response
     */
    public function index(OfferIndexRequest $request): Response
    {
        $offers = $this->offerRepository->getAllOffers(
            $request->query('categories'),
            $request->query('statuses'),
            $request->query('limit')
        );

        if (!empty($offers)) {
            return response($offers, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
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
     * @param StoreOfferRequest $request
     *
     * @return Response
     */
    public function store(StoreOfferRequest $request)
    {
        $offer = $this->offerService->createOffer($request->all());

        if ($offer !== null) {
            $offer = $this->offerRepository->getOfferById($offer->id);
            return response($offer, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $offer = Offer::with(['company', 'offerCategory', 'offerStatus', 'company.city', 'supervisor'])->where(
            ['id' => $id]
        )->get();

        if (isset($offer)) {
            return response(
                [
                    'status' => 'success',
                    'data' => $offer[0],
                    'message' => null,
                ],
                Response::HTTP_OK
            );
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => "Nie znaleziono oferty!",
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Offer $offer
     *
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
     * @param Offer   $offer
     *
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
     *
     * @return Response
     */
    public function destroy($id)
    {
        $offer = Offer::find($id);

        if ($offer->delete()) {
            return response("Offer has been deleted!", Response::HTTP_OK);
        } else {
            return response("Offer has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function accept(ChangeOfferStatusRequest $request, string $slug)
    {
        $offer = $this->offerRepository->acceptOfferBySlug($slug);

        if(!empty($offer)) {
            return response($offer, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_MODIFIED);
    }

    public function reject(ChangeOfferStatusRequest $request,  string $slug)
    {
        $offer = $this->offerRepository->rejectOfferBySlug($slug);

        if(!empty($offer)) {
            return response($offer, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_MODIFIED);
    }
}
