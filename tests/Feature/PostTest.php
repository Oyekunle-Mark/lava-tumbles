<?php

namespace Tests\Feature;

use App\Models\BlogPost;
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

    public function testSeeOneBlogPostWhenOne()
    {
        $post = new BlogPost();
        $post->title = 'Test title';
        $post->content = 'Test content';
        $post->save();

        $response = $this->get('/posts');

        $response->assertSeeText('Test title');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Test title',
        ]);
    }

    public function testStoreValid() {
        $params = [
            'title' => 'valid title here',
            'content' => 'at least 10 characters',
        ];

        $this->post('/posts', $params)
            ->assertStatus(302) // assert redirects to right page
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created');
    }
}
