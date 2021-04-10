<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostWhenDBEmpty()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No posts found.');
    }

    public function testSeeOneBlogPostWhenOneWithoutComment()
    {
        $post = $this->createDummyBlogPost();

        $response = $this->get('/posts');

        $response->assertSeeText('Test title');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Test title',
        ]);
    }

    public function testSeeOneBlogPostWhenOneWithComment()
    {
        $post = $this->createDummyBlogPost();
        Comment::factory()
            ->count(4)
            ->create([
                'blog_post_id' => $post->id,
            ]);

        $response = $this->get('/posts');

        $response->assertSeeText('4 comments');
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'valid title here',
            'content' => 'at least 10 characters',
        ];

        $this->post('/posts', $params)
            ->assertStatus(302) // assert redirects to right page
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'hey',
            'content' => 'ho',
        ];

        $this->post('/posts', $params)
            ->assertStatus(302) // assert redirects to right page
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateUpdateValid()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content',
        ]);

        $params = [
            'title' => 'some updated title',
            'content' => 'some update content',
        ];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302) // assert redirects to right page
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated!');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content',
        ]);
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'some updated title',
            'content' => 'some update content',
        ]);
    }

    public function testDelete()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Test title',
            'content' => 'Test content',
        ]);

        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted!');

        $this->assertDatabaseMissing('blog_posts', $post->toArray());
    }

    private function createDummyBlogPost(): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'Test title';
        // $post->content = 'Test content';
        // $post->save();

        // return $post;

        return BlogPost::factory()
            ->state([
                'title' => 'Test title',
                'content' => 'Test content',
            ])
            ->create();
    }
}
