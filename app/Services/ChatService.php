<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 08/05/2021
 * Time: 17:48
 */

namespace App\Services;

use App\Events\MessageSent;
use App\Notifications\JournalEntryCreated;
use App\Notifications\MessageSentNotification;
use App\Repositories\ChatRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

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
           Auth::user()->notify(new MessageSentNotification());

            return $result;
        }

        DB::rollBack();
        return null;
    }
}
