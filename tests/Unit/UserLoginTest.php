<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserLoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testViewLoginPage()
    {
        $response = $this->get(route('user_login'));

        $response->assertStatus(200);
    }

    public function testLoginUser()
    {
        factory(User::class, 3)->create();

        $user = factory(User::class)->create();

        $response = $this->call('POST', route('user_login'), [
            'username' => $user->username,
            'password' => 123456,
            '_token' => csrf_token()
        ]);

        $response->assertRedirect(route('users.index'));

    }
}
