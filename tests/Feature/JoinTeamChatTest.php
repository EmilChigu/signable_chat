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

test('a user cannot join without a username', function () {
    $response = $this->post('/', ['user_name' => 'emil_chigu']);
    $response->assertSessionHasErrors('username');
});

test('a user is presented with the correct component', function () {
    $this->get('/')->assertOk()->assertInertia(fn ($page) => $page->component('Welcome'));
});