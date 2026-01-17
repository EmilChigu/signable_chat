<?php

use App\Models\ChatMessage;

test('a user is able to get messages', function () {

    $message = ChatMessage::factory()->create([
        'username' => 'emil_chigu',
        'message' => 'some test string',
    ]);

    $this->withSession(['username' => 'emil_chigu']);

    $this->get('/chat')->assertOk()->assertInertia(fn ($page) => $page->component('ChatRoom')
        ->has('messages.data', 1)
        ->where('messages.data.0.message', $message->getAttribute('message'))
        ->where('messages.data.0.username', $message->getAttribute('username')));

});

test('a user cannot get messages if no session', function () {
    $this->get('/chat')->assertRedirect('/');
});
