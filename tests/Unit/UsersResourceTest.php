<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersResourceTestTest extends TestCase
{
    public function testUserIndex()
    {
        $user = $user = User::where('role', 2)->first();

        $response = $this->actingAs($user)->withSession($user->toArray())->get(route('users.index'));

        $response->assertStatus(200);
    }

    public function testUserCreate()
    {
        $user = $user = User::where('role', 2)->first();

        $response = $this->actingAs($user)->withSession($user->toArray())->get(route('users.create'));

        $response->assertStatus(200);
    }
    
    public function testUserStore()
    {
        $user = $user = User::where('role', 2)->first();

        $response = $this->actingAs($user)->withSession($user->toArray())->post(route('users.store'), [
            'username' => strtolower(str_random(7)),
            'email' => strtolower(str_random(6)) . '@gmail.com',
            'role' => 1,
            'password' => 123456,
            'password_confirmation' => 123456,
            '_token' => csrf_token(),
            '_method' => 'POST'
        ]);

        $response->assertRedirect(route('users.index'));
    }
    
    public function testUserEdit()
    {
        $user = $user = User::where('role', 2)->first();

        $response = $this->actingAs($user)->withSession($user->toArray())->get(route('users.edit', ['id' => $user->id]));

        $response->assertStatus(200);
    }
    
    public function testUserUpdate()
    {
        $user = User::where('role', 2)->first();

        $response = $this->actingAs($user)->withSession($user->toArray())->post(route('users.update', [$user->id]), [
            'username' => $user->username,
            'email' => $user->email,
            '_token' => csrf_token(),
            '_method' => 'PUT'
        ]);

        $response->assertRedirect(route('users.index'));
    }
    
    public function testUserDelete()
    {
        $user = User::where('role', 2)->first();

        $toBeDeleted = User::where('role', 1)->first();

        $response = $this->actingAs($user)->withSession($user->toArray())->post(route('users.destroy', [$toBeDeleted->id]), [
            '_token' => csrf_token(),
            '_method' => 'DELETE'
        ]);

        $response->assertRedirect(route('users.index'));
    }

    
}
