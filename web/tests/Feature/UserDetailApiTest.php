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
        $post = Post::first();

        $response = $this->json('GET', route('user.show', [
            'id' => $user->id,
        ]));

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'id' => $user->id,
                    'name' => $user->name,
                    'is_following' => false,
                    'is_followed' => false,
                    'profile' => [
                        'id' => $user->profile->id,
                        'content' => $user->profile->content,
                        'user_id' => $user->profile->user_id,
                    ],
                ], [
                    'id' => '2',
                    'content' => $post->content,
                    'myid' => $post->myid,
                    'platform' => $post->platform,
                    'user_id' => $post->user_id,
                    'user' => [
                        'id' => $post->user->id,
                        'name' => $post->user->name,
                        'is_followed' => false,
                        'is_following' => false,
                    ],
                ]);
    }
}
