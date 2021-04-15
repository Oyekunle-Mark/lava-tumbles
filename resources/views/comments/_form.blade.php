@auth
    <form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method="POST">
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
