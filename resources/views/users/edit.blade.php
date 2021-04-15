@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('users.update', ['user' => $user]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <img src="" />
            <div>
                <h4>Upload a different photo</h4>
                <input type="file" name="avatar" />
            </div>
        </div>
        <div>
            <label>Name</label>
            <input type="text" name="name" value="" />
        </div>
        <div>
            <input type="submit" value="Save Changes" />
        </div>
    </form>
@endsection
