<?php

test('can see chat page if has valid session', function () {
    $this->withSession(['username' => 'emil_chigu'])->get('/chat')->assertOk()->assertInertia(fn ($page) => $page->component('ChatRoom'));
});

test('cannot see chat page if no session', function () {
    $this->get('/chat')->assertRedirect('/');
});