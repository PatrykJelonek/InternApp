<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// This is only for testing purposes
Broadcast::channel('channel', function () {
    return true;
});

Broadcast::channel('chat.{uuid}', function () {
    return true;
});

// This is probably closer to what most would use in production
Broadcast::channel('user.{id}', function ($user, $id) {
    //return true if api user is authenticated
    return (int) $user->id === (int) $id;
});
