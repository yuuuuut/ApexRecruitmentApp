<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function ユーザーを作成して返却する()
    {
        $data = [
            'name'     => 'user',
            'email'    => 'user@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->json('POST', route('register'), $data);

        $user = User::first();
        $this->assertEquals($data['name'], $user->name);

        $response->assertStatus(201)
                ->assertJson(['name' => $user->name]);
    }
}
