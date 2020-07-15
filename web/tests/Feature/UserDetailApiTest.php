<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Profile;

class UserDetailApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function ユーザーを返却する()
    {
        factory(User::class)->create()->each(function ($user) {
            $user->profile()->save(factory(Profile::class)->make());
        });
        $user = User::first();

        $response = $this->json('GET', route('user.show', [
            'id' => $user->id,
        ]));

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'id'       => $user->id,
                    'following_count' => 0,
                    'followers_count' => 0,
                    'is_following' => false,
                    'psid'     => $user->profile->psid,
                    'content'  => $user->profile->content,
                    'platform' => $user->profile->platform,
                ]);
    }
}
