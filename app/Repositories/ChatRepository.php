<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 08/05/2021
 * Time: 00:37
 */

namespace App\Repositories;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ChatRepository implements ChatRepositoryInterface
{

    public function getChat(string $chatUuid)
    {
        return Chat::with(['users', 'messages'])->where(['uuid' => $chatUuid])->first();
    }

    public function getChatMessages(string $chatUuid)
    {
        $chat = Chat::with(['messages','messages.user'])->where(['uuid' => $chatUuid])->first();

        return $chat->messages()->with(['user'])->orderByDesc('created_at')->simplePaginate(config('global.numberOfReturnedMessages'));
    }

    public function getChatUsers(string $chatUuid)
    {
        $chat = Chat::with(['users'])->where(['uuid' => $chatUuid])->first();

        return $chat->users;
    }

    public function getUserChats(string $userId)
    {
        return Chat::with(['users'])->whereHas('users', function(Builder $query) use ($userId) {
            $query->where(['users.id' => $userId]);
        })->get();
    }

    public function saveMessage(string $chatUuid, int $userId, string $message)
    {
        $chatMessage = new ChatMessage();
        $chatMessage->uuid = Str::uuid();
        $chatMessage->content = $message;
        $chatMessage->chat_uuid = $chatUuid;
        $chatMessage->user_id = $userId;
        $chatMessage->freshTimestamp();

        if ($chatMessage->save()) {
            return ChatMessage::with(['user'])->where(['uuid' => $chatMessage->uuid])->first();
        }

        return null;
    }
}
