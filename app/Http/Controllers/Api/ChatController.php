<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatGetChatMessagesRequest;
use App\Http\Requests\ChatGetUserChatsRequest;
use App\Http\Requests\ChatSendMessageRequest;
use App\Repositories\ChatRepository;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    /**
     * @var ChatRepository
     */
    private $chatRepository;

    /**
     * @var ChatService
     */
    private $chatService;

    /**
     * ChatController constructor.
     *
     * @param ChatRepository $chatRepository
     * @param ChatService    $chatService
     */
    public function __construct(ChatRepository $chatRepository, ChatService $chatService)
    {
        $this->chatRepository = $chatRepository;
        $this->chatService = $chatService;
    }

    public function getUserChats(ChatGetUserChatsRequest $request)
    {
        $chats = $this->chatRepository->getUserChats($request->userId);

        if(!empty($chats)) {
            return response($chats, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getChatMessages(ChatGetChatMessagesRequest $request, string $uuid)
    {
        $messages = $this->chatRepository->getChatMessages($uuid);

        if(!empty($messages)) {
            return response($messages, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function sendMessage(ChatSendMessageRequest $request, string $uuid)
    {
        $result = $this->chatService->sendMessage($request->all());

        if ($result !== null) {
            return response($result, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
