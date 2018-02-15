<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $response = $this->post(route('login'), [
            'username' => 'laravel',
            'password' => 'password',
            '_token' => csrf_token()
        ]);
        $response->assertStatus(302);
        $response->assertSee('laravel');
    }
}
