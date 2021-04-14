@extends('layouts.app')

@section('title', 'Contact Page')

@section('content')
    <h1>Contact</h1>
    <p>Hello, Welcome to the Contact Page.</p>

    @can('home.secret')
        <p>
            <a href="{{ route('home.secret') }}">
                Go to special contact details
            </a>
        </p>
    @endcan
@endsection
