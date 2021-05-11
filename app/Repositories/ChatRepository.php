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
use Carbon\Carbon;
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
        $chat = Chat::with(['messages', 'messages.user'])->where(['uuid' => $chatUuid])->first();

        return $chat->messages()->with(['user'])->orderByDesc('created_at')->simplePaginate(
            config('global.numberOfReturnedMessages')
        );
    }

    public function getChatUsers(string $chatUuid)
    {
        $chat = Chat::with(['users'])->where(['uuid' => $chatUuid])->first();

        return $chat->users;
    }

    public function getUserChats(string $userId)
    {
        return Chat::with(['users'])->whereHas(
            'users',
            function (Builder $query) use ($userId) {
                $query->where(['users.id' => $userId]);
            }
        )->get();
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

    public function createChat(bool $oneOne = false): ?Chat
    {
        $chat = new Chat();
        $chat->uuid = Str::uuid();
        $chat->one_one = $oneOne;

        if ($chat->save()) {
            return $chat;
        }

        return null;
    }

    public function addUsersToChat(string $chatUuid, array $usersId)
    {
        $chat = Chat::with(['users'])->where(['uuid' => $chatUuid])->first();

        if ($chat !== null && $chat->one_one && (count($chat->users) + count($usersId)) > 2) {
            return $chat;
        }

        if ($chat !== null) {
            $chat->setUpdatedAt(Carbon::now()->timestamp)->update();

            foreach ($usersId as $userId) {
                $chat->users()->attach($userId);
            }

            return $chat;
        }

        return null;
    }

    public function getOneOneChatByUsersIds(int $firstUserId, int $secondUserId)
    {
        $chats = Chat::with(['users'])->where(['one_one' => true])->whereHas(
            'users',
            function (Builder $query) use ($firstUserId) {
                $query->where(['user_id' => $firstUserId]);
            }
        )->get();

        if (count($chats) > 0) {
            foreach ($chats as $chat) {
                foreach ($chat->users as $user) {
                    if ($user->id === $secondUserId) {
                        return $chat;
                    }
                }
            }
        }

        return null;
    }
}
