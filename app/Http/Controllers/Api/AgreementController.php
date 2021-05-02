<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AgreementChangeStatusRequest;
use App\Http\Requests\AgreementStoreRequest;
use App\Models\Agreement;
use App\Http\Controllers\Controller;
use App\Services\AgreementService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AgreementController extends Controller
{
    /**
     * @var AgreementService
     */
    private $agreementService;

    /**
     * AgreementController constructor.
     *
     * @param AgreementService $agreementService
     */
    public function __construct(AgreementService $agreementService)
    {
        $this->agreementService = $agreementService;
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
     * @param AgreementStoreRequest $request
     *
     * @return Response
     */
    public function store(AgreementStoreRequest $request)
    {
        $agreement = $this->agreementService->createAgreement($request->all());

        if ($agreement !== null) {
            return response($agreement, Response::HTTP_OK);
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
        $agreement = Agreement::with(
            [
                'company',
                'university',
                'author',
                'universitySupervisor',
                'offer.supervisor',
                'company.city',
                'university.city',
            ]
        )->where(['id' => $id])->get();

        if (isset($agreement)) {
            return response(
                [
                    'status' => 'success',
                    'data' => $agreement[0],
                    'message' => null,
                ],
                Response::HTTP_OK
            );
        } else {
            return response(
                [
                    'status' => 'error',
                    'data' => null,
                    'message' => "Nie znaleziono umowy!",
                ],
                Response::HTTP_NOT_FOUND
            );
        }
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

    public function accept(AgreementChangeStatusRequest $request, $slug) {
        $agreement = $this->agreementService->acceptAgreement($slug);

        if($agreement !== null) {
            return response($agreement, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NOT_MODIFIED);
    }

    public function reject(AgreementChangeStatusRequest $request, $slug) {
        $agreement = $this->agreementService->rejectAgreement($slug);

        if($agreement !== null) {
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
     * @param Request $request
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
}
