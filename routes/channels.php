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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('limit-changed.{user_id}', function ($user_id) {

    return (int) auth()->user()->id === (int) $user_id;

});

Broadcast::channel('stock-request.{user_id}', function ($user_id) {

    return (int) auth()->user()->id === (int) $user_id;

});
