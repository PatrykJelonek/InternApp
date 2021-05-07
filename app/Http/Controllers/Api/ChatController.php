<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatGetUserChatsRequest;
use App\Repositories\ChatRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    /**
     * @var ChatRepository
     */
    private $chatRepository;

    /**
     * ChatController constructor.
     *
     * @param ChatRepository $chatRepository
     */
    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function getUserChats(ChatGetUserChatsRequest $request)
    {
        $chats = $this->chatRepository->getUserChats($request->userId);

        if(!empty($chats)) {
            return response($chats, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
