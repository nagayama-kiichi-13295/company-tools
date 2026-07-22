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

@if($note->tags->isNotEmpty())
    <div class="note-tags">
        @foreach($note->tags as $tag)
            <span class="note-tag">{{ $tag->name }}</span>
        @endforeach
    </div>
@endif

<div class="note-detail-body">{{ $note->body }}</div>

<div class="content-actions">
    <a href="{{ route('notes.edit', $note) }}" class="btn-edit">編集する</a>
    
    <form action="{{ route('notes.destroy', $note) }}" method="post"
          onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete">削除する</button>
    </form>
</div>

<a href="{{ route('notes.index') }}" class="back-link">← メモ一覧へ戻る</a>

@endsection