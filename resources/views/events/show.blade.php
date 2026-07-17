@extends('layouts.app')

@section('title', 'イベント詳細')

@section('content')

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<h2>{{ $event->title }}</h2>

<p style="color: gray;">
    開催日時：{{ $event->held_at->format('Y/m/d H:i') }}
</p>

<div>{{ $event->body }}</div>

<br>

<p>参加者：{{ $event->participants->count() }} 人</p>

{{-- 参加／不参加ボタン --}}
<form action="{{ route('events.join', $event) }}" method="post">
    @csrf
    <button type="submit">
        {{ $isJoined ? '参加をやめる' : '参加する' }}
    </button>
</form>

<br>

{{-- 参加者一覧 --}}
@if($event->participants->isNotEmpty())
    <p>参加している人：</p>
    <ul>
        @foreach($event->participants as $participant)
            <li>{{ $participant->name }}</li>
        @endforeach
    </ul>
@endif

<br>

@can('update', $event)
    <a href="{{ route('events.edit', $event) }}">編集する</a>
    <br><br>
    <form action="{{ route('events.destroy', $event) }}" method="post"
          onsubmit="return confirm('本当に削除しますか?');">
        @csrf
        @method('DELETE')
        <button type="submit">削除する</button>
    </form>
    <br>
@endcan

<a href="{{ route('events.index') }}">イベント一覧へ戻る</a>

@endsection