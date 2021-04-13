<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('update-post', function ($user, $post) {
        //     return $user->id === $post->user_id;
        // });

        // Gate::define('delete-post', function ($user, $post) {
        //     return $user->id === $post->user_id;
        // });

        // Gate::define('posts.update', '\App\Policies\BlogPostPolity@update');
        // Gate::define('posts.delete', '\App\Policies\BlogPostPolity@delete');

        Gate::resource('posts', '\App\Policies\BlogPostPolity');

        // Gate::before(function ($user, $ability) {
        //     if ($user->is_admin && in_array($ability, ['posts.update'])) {
        //         return true;
        //     }
        // });

        // Gate::after(function ($user, $ability, $result) {
        //     if ($user->is_admin) {
        //         return true;
        //     }
        // });
    }
}
