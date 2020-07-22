<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\FollowUser;
use App\Models\Profile;
use App\Models\User;

class FollowApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->user2 = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function followできる()
    {
        $response = $this->actingAs($this->user)->json('POST', route('follow', [
            'id' => $this->user2->id,
        ]));

        $response->assertStatus(201)
            ->assertJsonFragment([
                'id' => $this->user->id,
                'is_following' => false,
                'name' => $this->user->name,
                'profile' => null
            ]);

        $this->assertEquals(1, $this->user->followings()->count());
    }

    /**
     * @test
     */
    public function unfollowできる()
    {
        $this->actingAs($this->user)->json('POST', route('follow', [
            'id' => $this->user2->id,
        ]));
        $this->assertEquals(1, $this->user->followings()->count());
        
        $response = $this->actingAs($this->user)->json('DELETE', route('unfollow', [
            'id' => $this->user2->id,
        ]));

        $response->assertStatus(200)->assertJsonFragment([
            'result' => 'OK',
        ]);

        $this->assertEquals(0, $this->user->followings()->count());
    }

    /**
     * @test
     */
    public function followしているユーザーを取得できる()
    {
        $this->actingAs($this->user)->json('POST', route('follow', [
            'id' => $this->user2->id,
        ]));

        $user = User::first();

        $data = [
            'user_id'  => $this->user2->id,
            'content'  => 'test',
        ];

        $this->actingAs($this->user2)->json('POST', route('profile.create'), $data);
        $profile = Profile::first();

        $response = $this->json('GET', route('follow.index', [
            'id' => $user->id,
        ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $this->user2->id,
                "is_followed" => false,
                'is_following' => false,
                'name' => $this->user2->name,
                'profile' => [
                    'id' => $profile->id,
                    'content' => 'test',
                    'user_id' => strval($this->user2->id),
                ],
            ]);
    }

    /**
     * @test
     */
    public function followerを取得できる()
    {
        $this->actingAs($this->user)->json('POST', route('follow', [
            'id' => $this->user2->id,
        ]));
        $user2 = User::find($this->user2->id);

        $data = [
            'user_id'  => $this->user->id,
            'content'  => 'test',
        ];

        $this->actingAs($this->user)->json('POST', route('profile.create'), $data);
        $profile = Profile::first();

        $response = $this->json('GET', route('follower.index', [
            'id' => $user2->id,
        ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $this->user->id,
                "is_followed" => false,
                'is_following' => false,
                'name' => $this->user->name,
                'profile' => [
                    'id' => $profile->id,
                    'content' => 'test',
                    'user_id' => strval($this->user->id),
                ],
            ]);
    }
}
