@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label>Email</label>
            <input name="email" value="{{ old("email") }}" required />

            @if ($errors->has("email"))
                <span>
                    <strong>{{ $errors->first("email") }}</strong>
                </span>
            @endif
        </div>
        <div>
            <label>Password</label>
            <input name="password" type="password" required />

            @if ($errors->has("password"))
                <span>
                    <strong>{{ $errors->first("password") }}</strong>
                </span>
            @endif
        </div>
        <div>
            <input type="checkbox" value="{{ old("remember") ? "checked" : "" }}" name="remember" />
            <label>Remember me</label>
        </div>

        <button type="submit">Login</button>
    </form>
@endsection
