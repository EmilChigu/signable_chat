<?php

namespace App\Http\Interfaces;

interface ChatMessageInterface
{
    public function send(string $username, string $message): void;

    public function getMessages();
}
