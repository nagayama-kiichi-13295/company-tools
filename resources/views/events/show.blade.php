@extends('layouts.app')

@section('title', 'イベント詳細')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/contents.css') }}">
@endpush

@section('content')

@if(session('success'))
    <p class="flash-success">{{ session('success') }}</p>
@endif

<h2>イベント</h2>

<div class="content-detail-title">{{ $event->title }}</div>

<div class="content-detail-meta">
    開催日時：{{ $event->held_at->format('Y年n月j日 H:i') }}
</div>

<div class="content-body">{{ $event->body }}</div>

<div class="participant-box">
    <strong>参加者：{{ $event->participants->count() }} 人</strong>

    @if($event->participants->isNotEmpty())
        <ul class="participant-list">
            @foreach($event->participants as $participant)
                <li>{{ $participant->name }}</li>
            @endforeach
        </ul>
    @endif
</div>

<form action="{{ route('events.join', $event) }}" method="post">
    @csrf
    <button type="submit" class="btn-join {{ $isJoined ? 'is-joined' : '' }}">
        {{ $isJoined ? '参加をやめる' : '参加する' }}
    </button>
</form>

@can('update', $event)
    <div class="content-actions" style="margin-top: 20px;">
        <a href="{{ route('events.edit', $event) }}" class="btn-edit">編集する</a>

        <form action="{{ route('events.destroy', $event) }}" method="post"
              onsubmit="return confirm('本当に削除しますか?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">削除する</button>
        </form>
    </div>
@endcan

<a href="{{ route('events.index') }}" class="back-link">← イベント一覧へ戻る</a>

@endsection