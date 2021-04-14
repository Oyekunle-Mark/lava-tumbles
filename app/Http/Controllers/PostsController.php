<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'posts.index',
            [
                'posts' => BlogPost::latest()->withCount('comments')->get(),
                'most_commented' => BlogPost::mostCommented()->take(5)->get(),
                'most_active_user' => User::withMostBlogPost()->take(5)->get(),
                'most_active_user_last_month' => User::withMostBlogPostLastMonth()->take(5)->get(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $post = BlogPost::create($validated);

        $request->session()->flash('status', 'The blog post was created');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_if(!isset($this->posts[$id]), 404);

        // return view('posts.show', [
        //     'post' => BlogPost::with(['comments' => function ($query) {
        //         return $query->latest();
        //     }])->findOrFail($id),
        // ]);

        return view('posts.show', [
            'post' => BlogPost::with('comments')->findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post.");
        // }
        $this->authorize($post);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post.");
        // }
        $this->authorize($post);

        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'Blog post was updated!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('delete-post', $post)) {
        //     abort(403, "You can't delete this blog post.");
        // }
        $this->authorize($post);

        $post->delete();

        session()->flash('status', 'Blog post was deleted!');
        return redirect()->route('posts.index');
    }
}
