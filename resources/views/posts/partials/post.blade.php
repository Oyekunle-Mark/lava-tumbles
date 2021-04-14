{{-- @break($key === 2) --}}
{{-- @continue($key === 1) --}}
@if($loop->even)
    <div>{{ $key }} . {{ $post->title }}</div>
    <p>by {{ $post->user->name }}</p>
@else
    <div style="background-color: silver">{{ $key }} . {{ $post->title }}</div>
@endif

<div>
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
