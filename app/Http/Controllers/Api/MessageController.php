<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Agreement::all();

        if (isset($messages))
            return response([
                'status' => 'success',
                'data' => $messages,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => "Nie znaleziono wiadomości!"
            ], Response::HTTP_NOT_FOUND);
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
        $vallidatedData  = $request->validate([
            'content' => 'required|max:254',
            'fromUserId' => 'required',
            'toUserId' => 'required'
        ]);

        $message = new Message;

        $message->content = $request->input('content');
        $message->from_user_id = $request->input('fromUserId');
        $message->to_user_id = $request->input('toUserId');
        $message->created_at = date('Y-m-d H:i:s');

        if($message->save())
        {
            return response([
                'status' => 'success',
                'data' => $message,
                'message' => null
            ], Response::HTTP_OK);
        } else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Nie udało się utworzyć wiadomości!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        $message = Faculty::find($id);

        if (isset($message))
            return response($message, Response::HTTP_OK);
        else
            return response("Message not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message = Message::find($id);

        if ($message->delete())
            return response("Message has been deleted!", Response::HTTP_OK);
        else
            return response("Message has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
