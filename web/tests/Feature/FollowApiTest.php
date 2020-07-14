<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\FollowUser;
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

        $response->assertStatus(200)->assertJsonFragment([
            'result' => 'OK',
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
}
