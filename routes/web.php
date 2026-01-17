<?php

use App\Http\Controllers\JoinTeamChatController;
use Illuminate\Support\Facades\Route;


Route::controller(JoinTeamChatController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/', 'store')->name('join');
});


Route::get('/chat', function () {
    return 'Chat Room';
})->name('chat');