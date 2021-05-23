<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 08/05/2021
 * Time: 17:48
 */

namespace App\Services;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Notifications\MessageSentNotification;
use App\Repositories\ChatRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatService
{
    /**
     * @var ChatRepository
     */
    private $chatRepository;

    /**
     * ChatService constructor.
     *
     * @param ChatRepository $chatRepository
     */
    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function sendMessage(array $data)
    {
        DB::beginTransaction();
        $result = $this->chatRepository->saveMessage($data['uuid'], $data['userId'], $data['message']);

        if ($result !== null) {
            DB::commit();
            broadcast(new MessageSent($result));

            $chat = Chat::with(['users'])->where(['uuid' => $result->chat_uuid])->first();

            if ($chat !== null) {
                foreach ($chat->users as $user) {
                    if ($user->id !== Auth::id()) {
                        $user->notify(new MessageSentNotification($result));
                    }
                }
            }

            return $result;
        }

        DB::rollBack();
        return null;
    }

    public function addUserToChat(array $data)
    {
        DB::beginTransaction();

        $chat = $this->chatRepository->getOneOneChatByUsersIds($data['firstUserId'], $data['secondUserId']);

        clock()->info('ChatService::addUserToChat', [
            'dump' => [
              'getOneOneChatByUsersIdsResult' => $chat,
            ],
        ]);

        if($chat === null) {
            $chat = $this->chatRepository->createChat(true);
        }

        if ($chat !== null) {
            $chat = $this->chatRepository->addUsersToChat($chat->uuid, [$data['firstUserId'], $data['secondUserId']]);

            if ($chat !== null) {
               DB::commit();
               return $chat;
            }
        }

        DB::rollBack();
        return null;
    }
}
