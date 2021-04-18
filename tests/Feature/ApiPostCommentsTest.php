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
        $this->createTestPost();

        $response = $this->json('GET', 'api/v1/posts/1/comments');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(0, 'data');
    }

    public function testBlogPostHasTenComments()
    {
        $commentCount = 10;

        $this->createTestPost()->each(function (BlogPost $blogPost) use ($commentCount) {
            $blogPost->comments()->saveMany(
                Comment::factory()
                    ->count($commentCount)
                    ->make([
                        'user_id' => $this->user()->id,
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

    public function testAddingCommentsWhenNotAuthenticated()
    {
        $this->createTestPost();

        $response = $this->json('POST', 'api/v1/posts/3/comments', [
            'content' => 'Hello',
        ]);

        $response->assertUnauthorized();
    }

    public function testAddingCommentWhenAuthenticated()
    {
        $this->createTestPost();

        $response = $this->actingAs($this->user(), 'api')->json('POST', 'api/v1/posts/4/comments', [
            'content' => 'Hello',
        ]);

        $response->assertStatus(201);
    }

    public function testAddingCommentWithInvalidData()
    {
        $this->createTestPost();

        $response = $this->actingAs($this->user(), 'api')->json('POST', 'api/v1/posts/5/comments', []);

        $response->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "content" => [
                        "The content field is required.",
                    ],
                ],
            ]);
    }

    protected function createTestPost()
    {
        return BlogPost::factory()->create([
            'user_id' => $this->user()->id,
        ]);
    }
}
