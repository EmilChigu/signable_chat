<?php

use App\Http\Interfaces\ChatMessageInterface;

test('a user can send a message', function () {

    $username = 'emil_chigu';
    $message = 'Hi everyone!';
    $this->withSession(['username' => $username])->post('/chat', ['message' => $message])->assertRedirectBack();

    $this->assertDatabaseHas('chat_messages', ['message' => $message, 'username' => $username]);
});

test('a message cannot be empty', function () {
    $username = 'emil_chigu';
    $this->withSession(['username' => $username])->post('/chat', ['message' => ''])->assertSessionHasErrors('message');
});

test('a user need a valid session to send a message', function () {
    $message = 'Hi everyone!';
    $this->post('/chat', ['message' => $message])->assertRedirect('/');
});

test('a user receives an error if message fails to save', function () {

    $this->mock(ChatMessageInterface::class, function ($mock) {
        $mock->shouldReceive('send')
            ->once()
            ->andThrow(new \Exception('Database is down'));
    });

    $this->withSession(['username' => 'emil_chigu'])
        ->post('/chat', ['message' => 'Peanut butter and banana on bread'])
        ->assertStatus(302)
        ->assertSessionHasErrors(['error' => 'Failed to send message']);

});
