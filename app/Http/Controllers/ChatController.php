<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ChatMessageInterface;
use App\Http\Requests\SendChatMessageRequest;
use App\Http\Resources\ChatMessagesResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Inertia\Response;

class ChatController extends Controller
{
    public function __construct(private readonly ChatMessageInterface $chatMessageService)
    {
        //
    }

    public function index(Request $request): Response|AnonymousResourceCollection
    {
        $messages = $this->chatMessageService->getMessages();

        if ($request->wantsJson()) {
            return ChatMessagesResource::collection($messages);
        }

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
            report($e);

            return back()->withErrors(['error' => 'Failed to send message']);
        }
    }
}
