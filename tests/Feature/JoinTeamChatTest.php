<?php

test('allows user to join if they provide a username', function () {
    $response = $this->post('/', ['username' => 'emil_chigu']);

    $response->assertRedirect('/chat');
    $response->assertSessionHas('username', 'emil_chigu');
});

test('a username is required to join', function () {
    $response = $this->post('/', ['username' => '']);
    $response->assertSessionHasErrors('username');
});