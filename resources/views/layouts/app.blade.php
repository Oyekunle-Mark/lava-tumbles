<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel App - @yield('title')</title>
</head>
<body>
    <div>
        <h4>Laravel Blog</h4>
        <nav>
            <a href="{{ route("home.index") }}">Home</a>
            <a href="{{ route("home.contact") }}">Contact</a>
            <a href="{{ route("posts.index") }}">Blog Posts</a>
            <a href="{{ route("posts.create") }}">Add</a>

            @guest
                <a href="{{ route("register") }}">Register</a>
                <a href="{{ route("login") }}">Login</a>
            @else
            <a href="{{ route("logout") }}" onclick="event.preventDefault();document.getElementById('logout-form').submit()">Logout ({{ Auth::user()->name }})</a>

            <form id="logout-form" action={{ route("logout") }} method="POST" style="display: none;">
                @csrf
            </form>
            @endguest
        </nav>
    </div>
    @if(session('status'))
        <div style="background-color: red">
            {{ session('status') }}
        </div>
    @endif
    @yield('content')
</body>
</html>
