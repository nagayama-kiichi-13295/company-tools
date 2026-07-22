@extends('layouts.app')
@section('title', '公開メモ')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/notes.css') }}">
@endpush

@section('content')

<h2>公開メモ</h2>

<p style="color: #6b7280; font-size:14px;">社内で公開されているメモの一覧です。</p>

@if($notes->isEmpty())
    <p>公開されているメモはありません</p>
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

                <div style="font-size: 12px; color:#9ca3af;">{{ $note->user->name }}</div>
            </div>
        @endforeach
    </div>
@endif

@endsection