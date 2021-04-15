<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class PostTagController extends Controller
{
    public function index($tag)
    {
        $tag = Tag::findOrFail($tag);

        return view('posts.index', [
            'posts' => $tag->blogPosts()
                ->latestWithRelations()
                ->get(),
            'most_commented' => [],
            'most_active_user' => [],
            'most_active_user_last_month' => [],
        ]);
    }
}
