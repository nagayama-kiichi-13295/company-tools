@extends('layouts.app')

@section('title', 'イベント編集')

@section('content')

<h2>イベント編集</h2>

@if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('events.update', $event) }}" method="post">
    @csrf
    @method('PUT')

    <div>
        <label>タイトル</label><br>
        <input type="text" name="title" value="{{ old('title', $event->title) }}">
    </div>
    <br>

    <div>
        <label>内容</label><br>
        <textarea name="body" rows="6" cols="50">{{ old('body', $event->body) }}</textarea>
    </div>
    <br>

    <div>
        <label>開催日時</label><br>
        <input type="datetime-local" name="held_at"
               value="{{ old('held_at', $event->held_at->format('Y-m-d\TH:i')) }}">
    </div>
    <br>

    <button type="submit">更新する</button>
</form>

<br>
<a href="{{ route('events.show', $event) }}">詳細へ戻る</a>

@endsection