@extends('layouts.app')

@section('title', $post['title'])

@section('content')
{{--  @if($post['is_new'])
<div>A new blog post. Using if</div>
@else
<div>Blog post is old. Using elseif</div>
@endif

@unless ($post['is_new'])
    <div>This is an old blog post... using unless</div>
@endunless  --}}

<h1>{{ $post->title }}</h1>
<p> {{ $post->content }}</p>

<span>Currently read by {{ $counter }} people.</span>

<h4>Comments</h4>

@forelse ($post->comments as $comment)
    <p>
        {{ $comment->content }}
    </p>
    <span>Created by {{ $comment->user->name }}</span>
@empty
    <p>No comments yet.</p>
@endforelse
@endsection
