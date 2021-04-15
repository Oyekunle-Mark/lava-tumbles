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

        if ($posts->count() === 0) {
            $this->command->info('There are no blog posts, so no comments will be created.');
            return;
        }

        $commentsCount = (int) $this->command->ask('How many comments would you like?', 150);

        $users = \App\Models\User::all();

        \App\Models\Comment::factory()
            ->count($commentsCount)
            ->make()
            ->each(function ($comment) use ($posts, $users) {
                $comment->blog_post_id = $posts->random()->id;
                $comment->user_id = $users->random()->id;
                $comment->save();
            });
    }
}
