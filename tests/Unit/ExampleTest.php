<?php

namespace Tests\Unit;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);

        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->post('/api/login', [
            'username' => 'laravel',
            'password' => 'password',
            '_token' => csrf_token(),
        ]);
        $response->assertStatus(404);

        $response = $this->json('POST', route('login'), [
            'username' => 'laravel',
            'password' => 'password',
            '_token' => csrf_token(),
        ]);

        $response->assertStatus(200)->assertJson([
            'message' => "Login success.",
        ]);
    }
}
