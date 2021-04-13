<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = \App\Models\BlogPost::all();

        \App\Models\Comment::factory()
            ->count(150)
            ->make()
            ->each(function ($comment) use ($posts) {
                $comment->blog_post_id = $posts->random()->id;
                $comment->save();
            });
    }
}
