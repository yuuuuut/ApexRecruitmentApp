<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Profile;

class ProfileApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function Profileの作成ができる()
    {
        $data = [
            'user_id'  => $this->user->id,
            'content'  => 'test',
        ];

        $response = $this->actingAs($this->user)
                        ->json('POST', route('profile.create'), $data);

        $profile = Profile::first();
        $this->assertEquals($data['user_id'], $profile->user_id);

        $response->assertStatus(201)
                ->assertJson(['user_id' => $profile->user_id]);
    }

}
