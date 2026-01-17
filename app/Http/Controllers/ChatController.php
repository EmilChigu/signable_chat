<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ChatMessageInterface;
use App\Http\Requests\SendChatMessageRequest;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{

    public function __construct(private readonly ChatMessageInterface $chatMessageService)
    {
        //
    }
    public function index(){
        return Inertia::render('ChatRoom');
    }
    
    public function store(SendChatMessageRequest $request){

        $validated = $request->validated();
        $message = $validated['message'];
        $username = $request->session()->get('username');

        $this->chatMessageService->send($username, $message);

        return back();
    }
}