<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiPostCommentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNewBlogPostDoesNotHaveComment()
    {
        BlogPost::factory()->create([
            'user_id' => $this->user()->id,
        ]);

        $response = $this->json('GET', 'api/v1/posts/1/comments');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(0, 'data');
    }

    public function testBlogPostHasTenComments()
    {
        $userId = $this->user()->id;
        $commentCount = 10;

        BlogPost::factory()->create([
            'user_id' => $userId,
        ])->each(function (BlogPost $blogPost) use ($userId, $commentCount) {
            $blogPost->comments()->saveMany(
                Comment::factory()
                    ->count($commentCount)
                    ->make([
                        'user_id' => $userId,
                    ]),
            );
        });

        $response = $this->json('GET', 'api/v1/posts/2/comments');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'content',
                        'created_at',
                        'updated_at',
                        'user' => [
                            'id',
                            'name',
                        ],
                    ],
                ],
                'links',
                'meta',
            ])
            ->assertJsonCount($commentCount, 'data');
    }
}
