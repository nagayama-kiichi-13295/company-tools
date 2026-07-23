@extends('layouts.app')
@section('title', 'メモ')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/notes.css') }}">
@endpush

@section('content')

<h2>メモ</h2>

@if(session('success'))
    <p class="flash-success">{{ session('success') }}</p>
@endif

<div class="note-toolbar">
    <a href="{{ route('notes.create') }}" class="btn-chat">+ 新しいメモ</a>
    
    @if($tags->isNotEmpty())
        <div class="tag-filter">
            <a href="{{ route('notes.index') }}"
                class="tag-chip {{ !$tagId ? 'is-active' : '' }}">すべて</a>
            @foreach($tags as $tag)
                <a href="{{ route('notes.index', ['tag_id' => $tag->id]) }}"
                    class="tag-chip {{ $tagId == $tag->id ? 'is-active' : '' }}">
                     {{ $tag->name }}
                </a>
            @endforeach
        </div>
    @endif
</div>

@if($notes->isEmpty())
    <p>メモはありません。</p>
@else
    <div class="note-grid">
        @foreach($notes as $note)
            <div class="note-card">
                <a href="{{ route('notes.show', $note) }}" class="note-card-title">
                    {{ $note->title }}
                </a>
                <div class="note-card-body">{{ Str::limit($note->body, 60) }}</div>

                @if($note->tags->isNotEmpty())
                    <div class="note-tags">
                        @foreach($note->tags as $tag)
                            <span class="note-tag">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif

@endsection