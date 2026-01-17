<?php

use App\Http\Controllers\JoinTeamChatController;
use App\Http\Middleware\HasUsername;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::controller(JoinTeamChatController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/', 'store')->name('join');
});


Route::get('/chat', function () {
    return Inertia::render('ChatRoom');
})->name('chat')->middleware(HasUsername::class);