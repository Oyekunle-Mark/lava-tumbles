@extends('layouts.app')

@section('content')
    <div>
        <img src="{{ $user->image ? $user->image->url() : '' }}" />
    </div>
    <div>
        <p>{{ $user->name }}</p>
    </div>
@endsection
