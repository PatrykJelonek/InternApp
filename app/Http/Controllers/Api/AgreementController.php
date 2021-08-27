<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AgreementActivateAgreementRequest;
use App\Http\Requests\AgreementChangeStatusRequest;
use App\Http\Requests\AgreementDeactivateAgreementRequest;
use App\Http\Requests\AgreementDeleteAgreementRequest;
use App\Http\Requests\AgreementShowRequest;
use App\Http\Requests\AgreementCreateAgreementRequest;
use App\Models\Agreement;
use App\Http\Controllers\Controller;
use App\Repositories\AgreementRepository;
use App\Repositories\OfferRepository;
use App\Repositories\UniversityRepository;
use App\Services\AgreementService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AgreementController extends Controller
{
    public const AGREEMENT_INACTIVE = false;

    public const REQUEST_FIELD_AGREEMENT_NAME = 'name';
    public const REQUEST_FIELD_AGREEMENT_DATE_FROM = 'dateFrom';
    public const REQUEST_FIELD_AGREEMENT_DATE_TO = 'dateTo';
    public const REQUEST_FIELD_AGREEMENT_PROGRAM = 'program';
    public const REQUEST_FIELD_AGREEMENT_SCHEDULE = 'schedule';
    public const REQUEST_FIELD_AGREEMENT_COMPANY_ID = 'companyId';
    public const REQUEST_FIELD_AGREEMENT_UNIVERSITY_SUPERVISOR_ID = 'universitySupervisorId';
    public const REQUEST_FIELD_AGREEMENT_PLACES_NUMBER = 'placesNumber';
    public const REQUEST_FIELD_AGREEMENT_OFFER_ID = 'offerId';
    public const REQUEST_FIELD_AGREEMENT_CONTENT = 'content';
    public const REQUEST_FIELD_AGREEMENT_UNIVERSITY_SLUG = 'universitySlug';

    /**
     * @var AgreementService
     */
    private $agreementService;

    /**
     * @var AgreementRepository
     */
    private $agreementRepository;

    /**
     * @var UniversityRepository
     */
    private $universityRepository;

    /**
     * @var OfferRepository
     */
    private $offerRepository;

    /**
     * AgreementController constructor.
     *
     * @param AgreementService     $agreementService
     * @param AgreementRepository  $agreementRepository
     * @param UniversityRepository $universityRepository
     * @param OfferRepository      $offerRepository
     */
    public function __construct(
        AgreementService $agreementService,
        AgreementRepository $agreementRepository,
        UniversityRepository $universityRepository,
        OfferRepository $offerRepository
    ) {
        $this->agreementService = $agreementService;
        $this->agreementRepository = $agreementRepository;
        $this->universityRepository = $universityRepository;
        $this->offerRepository = $offerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $agreements = Agreement::all();

        if (isset($agreements)) {
            return response(
                [
                    'status' => 'success',
                    'data' => $agreements,
                    'message' => null,
                ],
                Response::HTTP_OK
            );
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => "Nie znaleziono żadnej umowy!",
                ],
                Response::HTTP_NOT_FOUND
            );
        }
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
     * @param AgreementCreateAgreementRequest $request
     *
     * @return Response
     */
    public function createAgreement(AgreementCreateAgreementRequest $request): Response
    {
        DB::beginTransaction();
        $university = $this->universityRepository->getUniversityBySlug(
            $request->input(self::REQUEST_FIELD_AGREEMENT_UNIVERSITY_SLUG)
        );

        if (!is_null($university)) {
            $agreement = $this->agreementService->createAgreement(
                $request->input(self::REQUEST_FIELD_AGREEMENT_NAME),
                $request->input(self::REQUEST_FIELD_AGREEMENT_DATE_FROM),
                $request->input(self::REQUEST_FIELD_AGREEMENT_DATE_TO),
                $request->input(self::REQUEST_FIELD_AGREEMENT_PROGRAM),
                $request->input(self::REQUEST_FIELD_AGREEMENT_COMPANY_ID),
                $university->id,
                $request->input(self::REQUEST_FIELD_AGREEMENT_UNIVERSITY_SUPERVISOR_ID),
                $request->input(self::REQUEST_FIELD_AGREEMENT_PLACES_NUMBER),
                $request->input(self::REQUEST_FIELD_AGREEMENT_SCHEDULE),
                $request->input(self::REQUEST_FIELD_AGREEMENT_CONTENT),
                $request->input(self::REQUEST_FIELD_AGREEMENT_OFFER_ID),
                self::AGREEMENT_INACTIVE,
                Carbon::today()
            );

            $offer = $this->offerRepository->getOfferById(
                $request->input(self::REQUEST_FIELD_AGREEMENT_OFFER_ID)
            );

            $newOfferPlacesNumber = $offer->places_number - $request->input(self::REQUEST_FIELD_AGREEMENT_PLACES_NUMBER);
            $isOfferPlacesNumberChanged = $this->offerRepository
                ->changeOfferPlacesNumber(
                    $offer->id,
                    $newOfferPlacesNumber
                );

            if ($isOfferPlacesNumberChanged && !is_null($agreement)) {
                DB::commit();
                return response($agreement, Response::HTTP_CREATED);
            }
        }

        DB::rollBack();
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param AgreementShowRequest $request
     * @param                      $slug
     *
     * @return Response
     */
    public function show(AgreementShowRequest $request, $slug): ?Response
    {
        $agreement = $this->agreementRepository->getAgreementBySlug($slug);

        if (isset($agreement)) {
            return response($agreement, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Active specified agreements
     *
     * @param $id
     *
     * @return Response
     */
    public function active($id)
    {
        $agreement = Agreement::find($id);

        $agreement->is_active = 1;

        if ($agreement->save()) {
            return response(
                [
                    'status' => 'success',
                    'data' => null,
                    'message' => 'Porozumienie zostało potwierdzone!',
                ],
                Response::HTTP_OK
            );
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => "Nie udało się potwierdzić porozumienia!",
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function accept(AgreementChangeStatusRequest $request, $slug)
    {
        $agreement = $this->agreementService->acceptAgreement($slug);

        if ($agreement !== null) {
            return response($agreement, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_MODIFIED);
    }

    public function reject(AgreementChangeStatusRequest $request, $slug)
    {
        $agreement = $this->agreementService->rejectAgreement($slug);

        if ($agreement !== null) {
            return response($agreement, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_MODIFIED);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Agreement $agreement
     *
     * @return Response
     */
    public function edit(Agreement $agreement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request   $request
     * @param Agreement $agreement
     *
     * @return Response
     */
    public function update(Request $request, Agreement $agreement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Agreement $agreement
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agreement = Agreement::find($id);

        if ($agreement->delete()) {
            return response("Agreement has been deleted!", Response::HTTP_OK);
        } else {
            return response("Agreement has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function activateAgreement(AgreementActivateAgreementRequest $request, string $slug)
    {
        $result = $this->agreementService->setAgreementActiveStatus($slug, true);

        if ($result !== null) {
            return response($result, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function deactivateAgreement(AgreementDeactivateAgreementRequest $request, string $slug)
    {
        $result = $this->agreementService->setAgreementActiveStatus($slug, false);

        if ($result !== null) {
            return response($result, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function deleteAgreement(AgreementDeleteAgreementRequest $request, string $slug)
    {
        $result = $this->agreementService->deleteAgreement($slug);

        if ($result) {
            return response(null, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
