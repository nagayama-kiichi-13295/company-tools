@extends('layouts.app')

@section('title', 'お知らせ編集')

@section('content')

<h2>お知らせ編集</h2>

@if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('announcements.update', $announcement) }}" method="post">
    @csrf
    @method('PUT')

    <div>
        <label>タイトル</label><br>
        <input type="text" name="title" value="{{ old('title', $announcement->title) }}">
    </div>
    <br>

    <div>
        <label>本文</label><br>
        <textarea name="body" rows="6" cols="50">{{ old('body', $announcement->body) }}</textarea>
    </div>
    <br>

    <div>
        <label>
            <input type="checkbox" name="is_pinned" value="1"
                {{ old('is_pinned', $announcement->is_pinned) ? 'checked' : '' }}>
            重要なお知らせとして上部に固定する
        </label>
    </div>
    <br>

    <button type="submit">更新する</button>
</form>

<br>
<a href="{{ route('announcements.show', $announcement) }}">詳細へ戻る</a>

@endsection