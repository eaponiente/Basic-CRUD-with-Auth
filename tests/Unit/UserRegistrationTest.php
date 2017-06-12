<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRegistrationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegisterUser()
    {
        $response = $this->post(route('user_register'), [
            'username' => strtolower(str_random(7)),
            'email' => strtolower(str_random(6)) . '@gmail.com',
            'role' => 2,
            'password' => 123456,
            'password_confirmation' => 123456,
            '_token' => csrf_token()
        ]);

        $response->assertRedirect(route('users.index'));
    }
}
