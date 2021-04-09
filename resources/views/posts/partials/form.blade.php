<div><input type="text" name="title" value="{{ old('title') }}"></div>
<div><textarea name="content">{{ old('content') }}</textarea></div>
@if($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
