<?php

use App\Http\Controllers\JoinTeamChatController;
use App\Http\Controllers\ChatController;
use App\Http\Middleware\HasUsername;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::controller(JoinTeamChatController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/', 'store')->name('join');
});

Route::controller(ChatController::class)->middleware(HasUsername::class)->group(function () {
    Route::get('/chat', 'index')->name('chat');
    Route::post('/chat', 'store')->name('chat.send');
});