<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
    public function updating(BlogPost $blogPost)
    {
        Cache::tags(['blog_post'])->forget("blog-post-{$blogPost->id}");
    }

    public function deleting(BlogPost $blogPost)
    {
        $blogPost->comments()->delete();
        Cache::tags(['blog_post'])->forget("blog-post-{$blogPost->id}");
    }

    public function restoring(BlogPost $blogPost)
    {
        $blogPost->comments()->restore();
    }
}
