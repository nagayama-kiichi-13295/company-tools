@extends('layouts.app')

@section('title', 'お知らせ詳細')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/contents.css') }}">
@endpush

@section('content')

@if(session('success'))
    <p class="flash-success">{{ session('success') }}</p>
@endif

<h2>お知らせ</h2>

<div class="content-detail-title">
    @if($announcement->is_pinned)
        <span class="pin-mark">重要</span>
    @endif
    {{ $announcement->title }}
</div>

<div class="content-detail-meta">
    {{ $announcement->user->name }}／{{ $announcement->created_at->format('Y/m/d H:i') }}
</div>

<div class="content-body">{{ $announcement->body }}</div>

@can('update', $announcement)
    <div class="content-actions">
        <a href="{{ route('announcements.edit', $announcement) }}" class="btn-edit">編集する</a>

        <form action="{{ route('announcements.destroy', $announcement) }}" method="post"
              onsubmit="return confirm('本当に削除しますか?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">削除する</button>
        </form>
    </div>
@endcan

<a href="{{ route('announcements.index') }}" class="back-link">← お知らせ一覧へ戻る</a>

@endsection