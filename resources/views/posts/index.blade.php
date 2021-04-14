@extends('layouts.app')

@section('title', 'Blog Posts')

<div>
    <h3>Most Commented</h3>
    <ul>
        @foreach ($most_commented as $post_item)
            <li>
                <a href="{{ route('posts.show', ['post' => $post_item->id]) }}">
                    {{ $post_item->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

@section('content')
    @forelse ($posts as $key => $post)
        @include('posts.partials.post')
    @empty
        <div>No posts found.</div>
    @endforelse
@endsection
