<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendChatMessageRequest;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index(){
        return Inertia::render('ChatRoom');
    }
    
    public function store(SendChatMessageRequest $request){
        $validated = $request->validated();

        ChatMessage::create([
            'username' => $request->session()->get('username'),
            'message' => $validated['message'],
        ]);

        return back();
    }
}