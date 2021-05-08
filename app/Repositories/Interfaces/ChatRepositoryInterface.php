<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 08/05/2021
 * Time: 00:34
 */

namespace App\Repositories\Interfaces;

interface ChatRepositoryInterface
{
    public function getChat(string $chatUuid);

    public function getChatMessages(string $chatUuid);

    public function getChatUsers(string $chatUuid);

    public function getUserChats(string $userId);

    public function saveMessage(string $chatUuid, int $userId, string $message);
}
