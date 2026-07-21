@extends('layouts.app')
@section('title', 'お知らせ詳細')
@section('content')

@if(session('success'))
    <p class="flash-success">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p class="flash-error">{{ session('error') }}</p>
@endif

<h2>
    @if($announcement->is_pinned)
        [重要]
    @endif
    {{ $announcement->title }}
</h2>

<p style="color: gray;">
    {{ $announcement->user->name }}/{{ $announcement->created_at->format('Y/m/d H:i') }}
</p>

<div>{{ $announcement->body }}</div>

<br>

@can('update', $announcement)
    <a href="{{ route('announcements.edit', $announcement) }}">編集する</a>
    <br><br>
    <form action="{{ route('announcements.destroy', $announcement) }}" method="post"
          onsubmit="return confirm('本当に削除しますか?');">
        
        @csrf
        @method('DELETE')
        <button type="submit">削除する</button>
    </form>
    <br>
@endcan

<a href="{{ route('announcements.index') }}">お知らせ一覧へ戻る</a>

@endsection