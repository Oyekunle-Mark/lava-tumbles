<?php

namespace App\Listeners;

use App\Events\BlogPostPosted;
use App\Jobs\ThrottleMail;
use App\Mail\BlogPostAdded;
use App\Models\User;

class NotifyAdminWhenBlogPostIsCreated
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BlogPostPosted $event)
    {
        User::thatIsAnAdmin()->get()
            ->map(function (User $user) {
                ThrottleMail::dispatch(
                    new BlogPostAdded(),
                    $user,
                );
            });
    }
}
