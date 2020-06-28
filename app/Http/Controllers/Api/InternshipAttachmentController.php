<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\InternshipAttachment;
use Illuminate\Http\Request;

class InternshipAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole(['user']))
        {
        $internships_attachments = IntershipAttachment::all();

        if (isset($internships_attachments))
            return response([
                'status' => 'success',
                'data' => $internships_attachments,
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
        if(auth()->user()->hasRole(['user']))
        {
        $vallidatedData  = $request->validate([
            'intership_id' => 'required',
            'attachment_id' => 'required',
        ]);

        $intership_attachment = new IntershipAttachment;
        
        $intership_attachment->intership_id = $request->input('intership_id');
        $intership_attachment->attachment_id = $request->input('attachment_id');

        if($intership_attachment->save())
        {
            return response([
                'status' => 'success',
                'data' => $intership_attachment,
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
     * @param  \App\InternshipAttachment  $internshipAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(InternshipAttachment $internshipAttachment)
    {
        if(auth()->user()->hasRole(['user']))
        {
        $intership_attachment = AgreementAttachment::find($id);

        if (isset($intership_attachment))
            return response($intership_attachment, Response::HTTP_OK);
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
     * @param  \App\InternshipAttachment  $internshipAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(InternshipAttachment $internshipAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InternshipAttachment  $internshipAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InternshipAttachment $internshipAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InternshipAttachment  $internshipAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InternshipAttachment $internshipAttachment)
    {
        if(auth()->user()->hasRole(['user']))
        {
        $intership_attachment = InternshipAttachment::find($id);

        if ($intership_attachment->delete())
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
