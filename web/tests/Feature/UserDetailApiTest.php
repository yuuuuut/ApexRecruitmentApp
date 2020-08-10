<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Post;
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
            $user->post()->save(factory(Post::class)->make());
        });
        $user = User::first();
        
        factory(User::class)->create()->each(function ($user) {
            $user->profile()->save(factory(Profile::class)->make());
            $user->post()->save(factory(Post::class)->make());
        });
        $user2 = User::find(2);

        $this->actingAs($user2)->json('POST', route('follow', [
            'id' => $user->id,
        ]));

        $this->actingAs($user)->json('POST', route('follow', [
            'id' => $user2->id,
        ]));

        $response = $this->json('GET', route('user.show', [
            'id' => $user->id,
        ]));

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'id' => $user->id,
                    'is_false_notification' => [
                        true, 1
                    ],
                    'name' => $user->name,
                    'is_following' => false,
                    'is_followed' => false,
                    'profile' => [
                        'id' => $user->profile->id,
                        'content' => $user->profile->content,
                        'user_id' => $user->profile->user_id,
                    ],
                    'post' => [
                        'id' => $user->post->id,
                        'content' => $user->post->content,
                        'myid' => $user->post->myid,
                        'platform' => $user->post->platform,
                        'private' => $user->post->private,
                        'updated_at' => $user->post->updated_at,
                        'user' => [
                            'id' => $user->post->user->id,
                            'is_false_notification' => [
                                true, 1
                            ],
                            'name' => $user->post->user->name,
                            'is_following' => false,
                            'is_followed' => false,
                        ],
                        'user_id' => $user->post->user_id,
                    ],
                ], [
                    'id' => $user2->id,
                    'is_false_notification' => [
                        true, 1
                    ],
                    "is_followed" => true,
                    'is_following' => true,
                    'name' => $user2->name,
                    'profile' => [
                        'id' => $user2->profile->id,
                        'content' => $user2->profile->content,
                        'user_id' => $user2->profile->user_id,
                    ],
                ], [
                    'id' => $user2->id,
                    'is_false_notification' => [
                        true, 1
                    ],
                    "is_followed" => true,
                    'is_following' => true,
                    'name' => $user2->name,
                    'profile' => [
                        'id' => $user2->profile->id,
                        'content' => $user2->profile->content,
                        'user_id' => $user2->profile->user_id,
                    ],
                ]);
    }
}
