<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUserPostWasCommented;
use App\Mail\CommentPostedMarkdown;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    // uses route model binding
    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        // mailable instance should implement ShouldQueue interface
        // Mail::to($post->user)->send(
        //     new CommentPostedMarkdown($comment),
        // );

        $when = now()->addMinutes(1);

        Mail::to($post->user)->queue(
            new CommentPostedMarkdown($comment),
        );

        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkdown($comment),
        // );

        NotifyUserPostWasCommented::dispatch($comment);

        $request->session()->flash('status', 'Comment was created');

        return redirect()->back();
    }
}
