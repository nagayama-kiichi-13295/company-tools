@extends('layouts.app')

@section('title', 'お知らせ投稿')

@section('content')

<h2>お知らせ投稿</h2>

@if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('announcements.store') }}" method="post">
    @csrf

    <div>
        <label>タイトル</label><br>
        <input type="text" name="title" value="{{ old('title') }}">
    </div>
    <br>

    <div>
        <label>本文</label><br>
        <textarea name="body" rows="6" cols="50">{{ old('body') }}</textarea>
    </div>
    <br>

    <div>
        <label>
            <input type="checkbox" name="is_pinned" value="1"
                {{ old('is_pinned') ? 'checked' : '' }}>
            重要なお知らせとして上部に固定する
        </label>
    </div>
    <br>

    <button type="submit">投稿する</button>
</form>

<br>
<a href="{{ route('announcements.index') }}">一覧へ戻る</a>

@endsection