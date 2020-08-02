<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Post;

class PostIndexApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 正しいJSONを返す()
    {
        factory(Post::class, 3)->create();

        $response = $this->json('GET', '/api/posts?platform=PC');

        $posts = Post::with(['user'])->orderBy('created_at', 'desc')->get();

        $expected_data = $posts->map(function ($post) {
            return [
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
            ];
        })
        ->all();

        $response->assertStatus(200)
                ->assertJsonCount(3, 'data');
    }

    /**
     * @test
     */
    public function platformがPS4の場合正しいJSONを返す()
    {
        factory(Post::class, 3)->create();

        $response = $this->json('GET', '/api/posts?platform=PS4');

        $posts = Post::with(['user'])->orderBy('created_at', 'desc')->paginate();

        $expected_data = $posts->map(function ($post) {
            return [
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
            ];
        })
        ->all();

        $response->assertStatus(200)
                ->assertJsonCount(0, 'data');
    }
}
