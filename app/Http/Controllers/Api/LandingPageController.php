<?php

namespace App\Http\Controllers\Api;

use App\Constants\OfferStatusConstants;
use App\Http\Controllers\Controller;
use App\Http\Resources\LandingPageOfferResource;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LandingPageController extends Controller
{
    /**
     * @var OfferRepository
     */
    private $offerRepository;

    /**
     * LandingPageController constructor.
     *
     * @param OfferRepository $offerRepository
     */
    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function offers(Request $request)
    {
        $offers = $this->offerRepository->getAllOffers(null, [OfferStatusConstants::STATUS_ACCEPTED], 10);

        if (count($offers) > 0) {
            return response(LandingPageOfferResource::collection($offers), Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
