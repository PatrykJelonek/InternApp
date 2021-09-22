<?php

namespace App\Http\Controllers\Api;

use App\Events\OfferAccepted;
use App\Events\OfferRejected;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeOfferStatusRequest;
use App\Http\Requests\OfferIndexRequest;
use App\Http\Requests\OfferCreateOfferRequest;
use App\Models\Offer;
use App\Models\OfferStatus;
use App\Repositories\OfferRepository;
use App\Services\AttachmentService;
use App\Services\OfferService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;

class OfferController extends Controller
{
    public const REQUEST_FIELD_OFFER_COMPANY_ID = 'companyId';
    public const REQUEST_FIELD_OFFER_USER_ID = 'userId';
    public const REQUEST_FIELD_OFFER_NAME = 'name';
    public const REQUEST_FIELD_OFFER_PLACES_NUMBER = 'placesNumber';
    public const REQUEST_FIELD_OFFER_PROGRAM = 'program';
    public const REQUEST_FIELD_OFFER_SCHEDULE = 'schedule';
    public const REQUEST_FIELD_OFFER_CATEGORY_ID = 'offerCategoryId';
    public const REQUEST_FIELD_OFFER_STATUS_ID = 'offerStatusId';
    public const REQUEST_FIELD_OFFER_COMPANY_SUPERVISOR_ID = 'companySupervisorId';
    public const REQUEST_FIELD_OFFER_INTERVIEW = 'interview';
    public const REQUEST_FIELD_OFFER_DATE_FROM = 'dateFrom';
    public const REQUEST_FIELD_OFFER_DATE_TO = 'dateTo';
    public const REQUEST_FIELD_OFFER_ATTACHMENTS = 'attachment';
    public const REQUEST_FIELD_REJECT_OFFER_REASON = 'reason';

    /**
     * @var OfferService
     */
    private $offerService;

    /**
     * @var OfferRepository
     */
    private $offerRepository;

    /**
     * @var AttachmentService
     */
    private $attachmentService;

    /**
     * OfferController constructor.
     *
     * @param OfferService      $offerService
     * @param OfferRepository   $offerRepository
     * @param AttachmentService $attachmentService
     */
    public function __construct(
        OfferService $offerService,
        OfferRepository $offerRepository,
        AttachmentService $attachmentService
    ) {
        $this->offerService = $offerService;
        $this->offerRepository = $offerRepository;
        $this->attachmentService = $attachmentService;
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
            $request->query('onlyWithPlaces'),
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
     * @param OfferCreateOfferRequest $request
     *
     * @return Response
     */
    public function createOffer(OfferCreateOfferRequest $request): Response
    {
        DB::beginTransaction();
        $offer = $this->offerService->createOffer(
            $request->input(self::REQUEST_FIELD_OFFER_COMPANY_ID),
            $request->input(self::REQUEST_FIELD_OFFER_NAME),
            $request->input(self::REQUEST_FIELD_OFFER_PLACES_NUMBER),
            $request->input(self::REQUEST_FIELD_OFFER_PROGRAM),
            $request->input(self::REQUEST_FIELD_OFFER_CATEGORY_ID),
            $request->input(self::REQUEST_FIELD_OFFER_SCHEDULE),
            $request->input(self::REQUEST_FIELD_OFFER_DATE_FROM),
            $request->input(self::REQUEST_FIELD_OFFER_DATE_TO),
            $request->input(self::REQUEST_FIELD_OFFER_INTERVIEW),
            $request->input(self::REQUEST_FIELD_OFFER_COMPANY_SUPERVISOR_ID),
            $request->input(self::REQUEST_FIELD_OFFER_STATUS_ID),
            $request->input(self::REQUEST_FIELD_OFFER_ATTACHMENTS),
            $request->input(self::REQUEST_FIELD_OFFER_USER_ID)
        );

        if (!is_null($offer)) {
            if ($request->file(self::REQUEST_FIELD_OFFER_ATTACHMENTS) !== null) {
                $filename = "zalacznik_do_" . \Illuminate\Support\Str::slug(
                        $request->input(
                            self::REQUEST_FIELD_OFFER_NAME
                        ) . Carbon::today()->format('h_i_d_m_Y')
                    ) . '.' . $request->file(self::REQUEST_FIELD_OFFER_ATTACHMENTS)->getClientOriginalExtension();

                $path = $request->file(self::REQUEST_FIELD_OFFER_ATTACHMENTS)->storeAs('offers', $filename);
                $attachment = $this->attachmentService->storeAttachments(
                    $filename,
                    $request->file(self::REQUEST_FIELD_OFFER_ATTACHMENTS)->getMimeType(),
                    $path,
                    Auth::id()
                );

                if (!is_null($attachment)) {
                    $offer->attachments()->attach($attachment->id);

                    DB::commit();
                    return response($offer, Response::HTTP_CREATED);
                }

                Storage::delete($path);
            }

            return response($offer, Response::HTTP_CREATED);
        }

        DB::rollBack();
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $slug
     *
     * @return Response
     */
    public function show($slug)
    {
        $offer = $this->offerRepository->getOfferBySlug($slug);

        if (!empty($offer)) {
            return response($offer, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_FOUND);
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

        if (!empty($offer)) {
            OfferAccepted::dispatch(
                $offer
            );
            return response($offer, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_MODIFIED);
    }

    public function reject(ChangeOfferStatusRequest $request, string $slug)
    {
        $offer = $this->offerRepository->rejectOfferBySlug($slug);

        if (!empty($offer)) {
            OfferRejected::dispatch(
                $offer,
                $request->input(self::REQUEST_FIELD_REJECT_OFFER_REASON)
            );
            return response($offer, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_MODIFIED);
    }
}
