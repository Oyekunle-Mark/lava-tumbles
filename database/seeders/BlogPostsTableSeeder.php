<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();

        \App\Models\BlogPost::factory()
            ->count(50)
            ->make()
            ->each(function ($post) use ($users) {
                $post->user_id = $users->random()->id;
                $post->save();
            });
    }
}
