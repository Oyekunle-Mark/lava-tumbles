@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label>Name</label>
            <input name="name" value="{{ old("name") }}" required />

            @if ($errors->has("name"))
                <span>
                    <strong>{{ $errors->first("name") }}</strong>
                </span>
            @endif
        </div>
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
            <label>Confirm Password</label>
            <input name="password_confirmation" type="password" required />
        </div>

        <button type="submit">Register</button>
    </form>
@endsection
