<?php

namespace App\Http\Controllers\Api;

use App\AgreementAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AgreementAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        auth()->user()->hasRole(['admin', 'student', 'company-worker', 'university-worker']);
        $agreements_attachments = AgreementAttachment::all();

        if (isset($agreements_attachments))
            return response([
                'status' => 'success',
                'data' => $agreements_attachments,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => "Nie znaleziono powiązań!"
            ], Response::HTTP_UNAUTHORIZED);
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
        auth()->user()->hasRole(['admin', 'student', 'company-worker', 'university-worker']);
        $vallidatedData  = $request->validate([
            'agreement_id' => 'required',
            'attachment_id' => 'required',
        ]);

        $offer_attachment = new AgreementAttachment;

        $offer_attachment->agreement_id = $request->input('agreement_id');
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
     * @param AgreementAttachment $agreementAttachment
     * @return Response
     */
    public function show(AgreementAttachment $agreementAttachment)
    {
        auth()->user()->hasRole(['admin', 'student', 'company-worker', 'university-worker']);
        $agreement_attachment = AgreementAttachment::find($id);

        if (isset($agreement_attachment))
            return response($agreement_attachment, Response::HTTP_OK);
        else
            return response("Relation not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AgreementAttachment $agreementAttachment
     * @return Response
     */
    public function edit(AgreementAttachment $agreementAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AgreementAttachment $agreementAttachment
     * @return Response
     */
    public function update(Request $request, AgreementAttachment $agreementAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AgreementAttachment $agreementAttachment
     * @return Response
     */
    public function destroy(AgreementAttachment $agreementAttachment)
    {
        auth()->user()->hasRole(['admin', 'student', 'company-worker', 'university-worker']);
        $agreement_attachment = AgreementAttachment::find($id);

        if ($agreement_attachment->delete())
            return response("Relation has been deleted!", Response::HTTP_OK);
        else
            return response("Relation has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
