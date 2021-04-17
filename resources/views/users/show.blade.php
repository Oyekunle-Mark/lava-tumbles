@extends('layouts.app')

@section('content')
    <div>
        <img src="{{ $user->image ? $user->image->url() : '' }}" />
    </div>
    <div>
        <h1>{{ $user->name }}</h1>

        <p>Currently viewed by {{ $counter }} other users.</p>
    </div>

    @auth
        <form action="{{ route('users.comments.store', ['user' => $user->id]) }}" method="POST">
            @csrf
            <div>
                <textarea type="text" name="content"></textarea>
            </div>
            <div>
                <input type="submit" value="Add Comment"/>
            </div>

            @if($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    @else
        <a href="{{ route('login') }}">Sign in to post comment</a>
    @endauth

    <hr />

    @forelse ($user->commentsOn as $comment)
        <p>
            {{ $comment->content }}
        </p>
        <span>Created by {{ $comment->user->name }}</span>
    @empty
        <p>No comments yet.</p>
    @endforelse
@endsection
