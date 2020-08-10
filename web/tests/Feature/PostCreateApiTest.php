<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Post;

class PostCreateApiTest extends TestCase
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
    public function Postの作成ができる()
    {
        $data = [
            'user_id' => $this->user->id,
            'content' => 'TestContent',
            'myid' => 'testid',
            'platform' => 'PS4',
            'private' => false
        ];

        $response = $this->actingAs($this->user)
                        ->json('POST', route('post.create'), $data);

        $post = Post::first();
        $this->assertEquals($data['content'], $post->content);

        $response->assertStatus(201)
                ->assertJson(['user_id' => $post->user_id]);
    }

    /**
     * @test
     */
    public function Postが存在する場合更新される()
    {
        $data = [
            'user_id' => $this->user->id,
            'content' => 'TestContent',
            'myid' => 'testid',
            'platform' => 'PS4',
            'private' => false
        ];
        $response = $this->actingAs($this->user)->json('POST', route('post.create'), $data);

        $post = Post::first();
        $response->assertStatus(201)->assertJson(['user_id' => $post->user_id]);
        $this->assertEquals(1 , Post::count());

        $data = [
            'user_id' => $this->user->id,
            'content' => 'TestContent2',
            'myid' => 'testid',
            'platform' => 'PS4',
            'private' => false
        ];
        $response = $this->actingAs($this->user)->json('POST', route('post.create'), $data);

        $post = Post::first();
        $response->assertStatus(201)->assertJson(['user_id' => $post->user_id]);
        $this->assertEquals(1 , Post::count());
    }
}
