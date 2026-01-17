<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoinTeamChatRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JoinTeamChatController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Welcome');
    }

    public function store(JoinTeamChatRequest $request): RedirectResponse
    {

        $validated = $request->validated();

        $request->session()->put('username', $validated['username']);

        return redirect()->route('chat');
    }
}