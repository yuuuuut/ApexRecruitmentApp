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

        $response = $this->json('GET', route('post.index'));

        $posts = Post::with(['user'])->orderBy('created_at', 'desc')->paginate();

        $expected_data = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'content' => $post->content,
                'myid' => $post->myid,
                'platform' => $post->platform,
                'user_id' => $post->user_id,
                'user' => [
                    'name' => $post->user->name,
                    'is_followed' => false,
                    'is_following' => false,
                ]
            ];
        })
        ->all();

        $response->assertStatus(200)
                ->assertJsonCount(3, 'data');
                /*
                ->assertJsonFragment([
                    "data" => $expected_data,
                ]);
                */
    }
}
