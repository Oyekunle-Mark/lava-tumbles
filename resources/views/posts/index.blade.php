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

<div>
    <h3>Most Active User</h3>
    <ul>
        @foreach ($most_active_user as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>
</div>

<div>
    <h3>Most Active User Last Month</h3>
    <ul>
        @foreach ($most_active_user_last_month as $month_user)
            <li>{{ $month_user->name }}</li>
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
