<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('laporan.masuk.{id_daerah}', function ($user, $id_daerah) {
    return $user->role === 'Super Admin' || ((int) $user->id_daerah === (int) $id_daerah);
});

Broadcast::channel('laporan.masuk.semua', function ($user) {
    return $user->role === 'Super Admin';
});

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
