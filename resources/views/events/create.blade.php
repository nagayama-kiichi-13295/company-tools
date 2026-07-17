@extends('layouts.app')

@section('title', 'イベント作成')

@section('content')

<h2>イベント作成</h2>

@if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('events.store') }}" method="post">
    @csrf

    <div>
        <label>タイトル</label><br>
        <input type="text" name="title" value="{{ old('title') }}">
    </div>
    <br>

    <div>
        <label>内容</label><br>
        <textarea name="body" rows="6" cols="50">{{ old('body') }}</textarea>
    </div>
    <br>

    <div>
        <label>開催日時</label><br>
        <input type="datetime-local" name="held_at" value="{{ old('held_at') }}">
    </div>
    <br>

    <button type="submit">作成する</button>
</form>

<br>
<a href="{{ route('events.index') }}">一覧へ戻る</a>

@endsection