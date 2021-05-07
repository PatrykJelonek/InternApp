<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 08/05/2021
 * Time: 00:37
 */

namespace App\Repositories;

use App\Models\Chat;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ChatRepository implements ChatRepositoryInterface
{

    public function getChat(string $chatUuid)
    {
        return Chat::where(['uuid' => $chatUuid])->get();
    }

    public function getChatMessages(string $chatUuid)
    {
        $chat = $this->getChat($chatUuid);

        return $chat->messages();
    }

    public function getChatUsers(string $chatUuid)
    {
        $chat = $this->getChat($chatUuid);

        return $chat->users();
    }

    public function getUserChats(string $userId)
    {
        return Chat::with(['messages'])->whereHas('users', function(Builder $query) use ($userId) {
            $query->where(['users.id' => $userId]);
        })->get();
    }
}
