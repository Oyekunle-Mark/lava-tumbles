{{-- @break($key === 2) --}}
{{-- @continue($key === 1) --}}
@if($loop->even)
    <div>{{ $key }} . {{ $post->title }}</div>

    {{-- @if(isset($userId))
        by <a href="{{ route('users.show', ['user' => $userId]) }}">
            {{ $post->user->name }}
        </a>
    @else --}}
        <p>by {{ $post->user->name }}</p>
    {{-- @endif --}}
@else
    <div style="background-color: silver">{{ $key }} . {{ $post->title }}</div>
@endif

<p>
    @foreach ($post->tags as $tag)
        <a href="{{ route('posts.tags.index', ['tag' => $tag->id]) }}">
            {{ $tag->name }}
        </a>
    @endforeach
</p>

<div>
    <h3>
        @if ($post->trashed())
            <del style="color: red;">Trashed</del>
        @endif
    </h3>
    @can('update', $post)
        <a href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
    @endcan

    {{--  @cannot('delete', $post)
        <p>You cannot delete this post.</p>
    @endcannot  --}}

    @can('delete', $post)
        <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="Delete!">
        </form>
    @endcan

    @if ($post->comments_count)
        <p>{{ $post->comments_count }} comments</p>
    @else
        <p>No comments yet!</p>
    @endif
</div>
