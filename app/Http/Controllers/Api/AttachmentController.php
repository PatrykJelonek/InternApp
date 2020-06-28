<?php

namespace App\Http\Controllers\Api;

use App\Attachment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttachmentController extends Controller
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
        $attachments = Attachment::all();

        if (isset($attachments))
            return response($attachments, Response::HTTP_OK);
        else
            return response("Attachments not found!", Response::HTTP_NOT_FOUND);
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
            'file' => 'required|mimes:pdf,xlx,csv,jpg,png',
            'name' => 'required|max:128',
            'description' => 'required|max:255',
            'type' => 'required|max:8',
            'user_id' => 'required'
        ]);

        $attachment = new Attachment;
        
        $attachment->name = $request->input('name');
        $attachment->description = $request->input('description');
        $attachment->type = $request->input('type');
        $attachment->user_id = $request->input('user_id');
        $attachment->created_at = date('Y-m-d H:i:s');

        if($attachment->save())
        {
            $fullfileName = $name.'.'.$request->file->extension();
            $request->file->move(public_path('uploads'), $fullfileName);//zapis w folderze

            return response([
                'status' => 'success',
                'data' => $attachment,
                'message' => null
            ], Response::HTTP_OK);
        } else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Can not create attachment!'
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
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(auth()->user()->hasRole(['admin', 'student', 'company-worker', 'university-worker']))
       {
        $attachment = Attachment::find($id);

        if (isset($attachment))
            return response($attachment, Response::HTTP_OK);
        else
            return response("Attachment not found!", Response::HTTP_NOT_FOUND);
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
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachment $attachment)
    {
        if(auth()->user()->hasRole(['admin', 'student', 'company-worker', 'university-worker']))
       {
        $attachments = Attachment::find($request->input("id"));

        if (isset($attachment)) {
            $attachment->name = $request->input("name");
            $attachment->description = $request->input("description");
            $attachment->type = $request->input("type");
            $attachment->user_id = $request->input("user_id");

            if ($attachment->save())
                return response($attachment, Response::HTTP_OK);
        }

        return response("Attachment has not been updated!", Response::HTTP_NOT_MODIFIED);
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->hasRole(['admin', 'student', 'company-worker', 'university-worker']))
       {
        $attachment = Attachment::find($id);

        if ($attachment->delete())
            return response("Attachment has been deleted!", Response::HTTP_OK);
        else
            return response("Attachment has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
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
