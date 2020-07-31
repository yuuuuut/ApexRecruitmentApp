<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Post;

class PostDetailApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 正しいJSONを返す()
    {
        factory(Post::class)->create();
        $post = Post::first();

        $response = $this->json('GET', route('post.show', [
            'id' => $post->id,
        ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $post->id,
                'content' => $post->content,
                'myid' => $post->myid,
                'platform' => $post->platform,
                'user' => [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                    'is_followed' => false,
                    'is_following' => false,
                ],
                'user_id' => $post->user_id,
            ]);
    }

    /**
     * @test
     */
    public function currentUserの投稿を取得できる()
    {
        factory(Post::class)->create();
        $post = Post::first();

        $response = $this->json('GET', route('post.current', [
            'id' => $post->user->id,
        ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $post->id,
                'content' => $post->content,
                'myid' => $post->myid,
                'platform' => $post->platform,
                'user' => [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                    'is_followed' => false,
                    'is_following' => false,
                ],
                'user_id' => $post->user_id,
            ]);
    }
}
