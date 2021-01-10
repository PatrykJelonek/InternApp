<?php

namespace App\Http\Controllers\Api;

use App\Models\AgreementAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgreementAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if(auth()->user()->hasRole(['admin', 'student', 'company-worker', 'university-worker']))
       {
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
            ], Response::HTTP_NOT_FOUND);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
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
        if(auth()->user()->hasRole(['admin', 'student', 'company-worker', 'university-worker']))
        {
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
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AgreementAttachment  $agreementAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(AgreementAttachment $agreementAttachment)
    {
        if(auth()->user()->hasRole(['admin', 'student', 'company-worker', 'university-worker']))
        {
        $agreement_attachment = AgreementAttachment::find($id);

        if (isset($agreement_attachment))
            return response($agreement_attachment, Response::HTTP_OK);
        else
            return response("Relation not found!", Response::HTTP_NOT_FOUND);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AgreementAttachment  $agreementAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(AgreementAttachment $agreementAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AgreementAttachment  $agreementAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgreementAttachment $agreementAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AgreementAttachment  $agreementAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgreementAttachment $agreementAttachment)
    {
        if(auth()->user()->hasRole(['admin', 'student', 'company-worker', 'university-worker']))
        {
        $agreement_attachment = AgreementAttachment::find($id);

        if ($agreement_attachment->delete())
            return response("Relation has been deleted!", Response::HTTP_OK);
        else
            return response("Relation has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
