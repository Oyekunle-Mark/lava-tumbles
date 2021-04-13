<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user_doe = \App\Models\User::factory()->state([
            'name' => 'John Doe',
            'email' => 'jd@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ])->create();
        $else = \App\Models\User::factory(20)->create();

        $users = $else->concat([$user_doe]);

        $posts = \App\Models\BlogPost::factory()
            ->count(50)
            ->make()
            ->each(function ($post) use ($users) {
                $post->user_id = $users->random()->id;
                $post->save();
            });

        $comments = \App\Models\Comment::factory()
            ->count(150)
            ->make()
            ->each(function ($comment) use ($posts) {
                $comment->blog_post_id = $posts->random()->id;
                $comment->save();
            });
    }
}
