<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ChatMessageInterface;
use App\Http\Requests\SendChatMessageRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ChatController extends Controller
{
    public function __construct(private readonly ChatMessageInterface $chatMessageService)
    {
        //
    }

    public function index(): Response
    {
        $messages = $this->chatMessageService->getMessages();

        return Inertia::render('ChatRoom', compact('messages'));
    }

    public function store(SendChatMessageRequest $request): RedirectResponse
    {

        $validated = $request->validated();
        $message = (string) $validated['message'];
        $username = (string) $request->session()->get('username', '');

        try {
            $this->chatMessageService->send($username, $message);

            return back()->with('success', 'Message sent successfully');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send message');
        }
    }
}
