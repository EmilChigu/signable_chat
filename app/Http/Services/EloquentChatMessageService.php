<?php

namespace App\Http\Services;

use App\Http\Interfaces\ChatMessageInterface;
use App\Models\ChatMessage;
use Illuminate\Contracts\Pagination\Paginator;

class EloquentChatMessageService implements ChatMessageInterface
{
    public function send(string $username, string $message): void
    {

        ChatMessage::create([
            'username' => $username,
            'message' => $message,
        ]);
    }

    public function getMessages(): Paginator
    {
        return ChatMessage::query()->latest()->simplePaginate(50);
    }
}
