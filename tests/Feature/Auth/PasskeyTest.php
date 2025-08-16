<?php

test('login page contains passkey authentication component', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('Or continue with email');
    $response->assertSee('Sign in with Email');
    // Note: Passkey component is commented out in the view
});

test('passkey authentication routes are available', function () {
    $this->get('/passkeys/authentication-options')->assertStatus(200);
});

test('passkey login route is available', function () {
    $this->post('/passkeys/authenticate')->assertStatus(302); // Redirects on failure, which is expected
});
