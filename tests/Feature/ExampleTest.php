<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(302); // Root redirects to login when not authenticated
    $response->assertRedirect('/login');
});
