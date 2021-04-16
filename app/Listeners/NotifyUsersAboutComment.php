<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUserPostWasCommented;
use App\Jobs\ThrottleMail;
use App\Mail\CommentPostedMarkdown;

class NotifyUsersAboutComment
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        ThrottleMail::dispatch(
            new CommentPostedMarkdown($event->comment),
            $event->comment->commentable->user,
        )->onQueue('low');
        NotifyUserPostWasCommented::dispatch($event->comment)
            ->onQueue('high');
    }
}
