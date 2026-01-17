<?php

namespace App\Http\Services;

use App\Http\Interfaces\ChatMessageInterface;
use App\Models\ChatMessage;

class EloquentChatMessageService implements ChatMessageInterface
{

    public function send(string $username, string $message)
    {

        return ChatMessage::create([
            'username' => $username,
            'message' => $message,
        ]);
    }

    public function getMessages()
    {
        // TODO: Implement getChatMessages() method.
    }
}