<?php

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
