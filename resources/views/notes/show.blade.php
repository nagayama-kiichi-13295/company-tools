@extends('layouts.app')
@section('title', $note->title)

@push('css')
    <link rel="stylesheet" href="{{ asset('css/notes.css') }}">
@endpush

@section('content')

@if(session('success'))
    <p class="flash-success">{{ session('success') }}</p>
@endif

<h2>{{ $note->title }}</h2>

@if($note->is_public)
    <span class="badge badge-available">公開中</span>
@endif

@if($note->tags->isNotEmpty())
    <div class="note-tags">
        @foreach($note->tags as $tag)
            <span class="note-tag">{{ $tag->name }}</span>
        @endforeach
    </div>
@endif

<div class="note-detail-body">{{ $note->body }}</div>

@if($note->user_id === auth()->id())
    <div class="content-actions">

        <form action="{{ route('notes.togglePublic', $note) }}" method="post">
            @csrf
            @if($note->is_public)
                <button type="submit" class="btn-edit">公開を停止する</button>
            @else
                <button type="submit" class="btn-purchase">社内に公開する</button>
            @endif
        </form>

        <a href="{{ route('notes.edit', $note) }}" class="btn-edit">編集する</a>

        <form action="{{ route('notes.destroy', $note) }}" method="post"
              onsubmit="return confirm('本当に削除しますか？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">削除する</button>
        </form>
    </div>
@else
    <p style="color: #6b7280; font-size:14px;">{{ $note->user->name }} さんの公開メモ</p>
@endif

<a href="{{ route('notes.index') }}" class="back-link">← メモ一覧へ戻る</a>

@endsection