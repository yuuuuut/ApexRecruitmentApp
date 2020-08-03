<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Post;
use Auth;

class TimeLineApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        factory(User::class)->create()->each(function ($user) {
            factory(Post::class)->create(['user_id' => $user->id ]);
        });

        factory(User::class)->create()->each(function ($user) {
            factory(Post::class)->create(['user_id' => $user->id ]);
        });

        $this->user2 = User::find(2);
        $this->user3 = User::find(3);

        $response = $this->actingAs($this->user)->json('POST', route('follow', [
            'id' => $this->user2->id,
        ]));

        $response = $this->actingAs($this->user)->json('POST', route('follow', [
            'id' => $this->user3->id,
        ]));
    }

    /**
     * @test
     */
    public function 正しいJSONを返す()
    {
        $response = $this->actingAs($this->user)
                        ->json('GET', '/api/timeline');

        $users = Auth::user()->followings()->with(['post.user'])->get();

        $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'is_following' => false,
                'is_followed' => false,
                'post' => [
                    'id' => $user->post->id,
                    'content' => $user->post->content,
                    'myid' => $user->post->myid,
                    'platform' => $user->post->platform,
                    'user' => [
                        'id' => $user->post->userid,
                        'name' => $user->post->user->name,
                        'is_following' => false,
                        'is_followed' => false,
                    ],
                ],
            ];
        })
        ->all();

        $response->assertStatus(200)
                ->assertJsonCount(2, 'data');
    }
}
