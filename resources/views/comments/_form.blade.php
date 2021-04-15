@auth
    <form action="#" method="POST">
        @csrf
        <div>
            <textarea type="text" name="content"></textarea>
        </div>
        <div>
            <input type="submit" value="Add Comment"/>
        </div>
    </form>
@else
    <a href="{{ route('login') }}">Sign in to post comment</a>
@endauth

<hr />
