<?php

namespace App\Http\Interfaces;

interface ChatMessageInterface
{

    public function send(string $username, string $message);

    public function getMessages();

}