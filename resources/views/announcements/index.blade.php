@extends('layouts.app')

@section('title', 'お知らせ')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/contents.css') }}">
@endpush

@section('content')

<h2>お知らせ</h2>

@if(session('success'))
    <p class="flash-success">{{ session('success') }}</p>
@endif

@can('create', App\Models\Announcement::class)
    <a href="{{ route('announcements.create') }}" class="create-link">＋ お知らせを投稿する</a>
@endcan

@if($announcements->isEmpty())
    <p>お知らせはありません。</p>
@else
    <div class="content-list">
        @foreach($announcements as $announcement)
            <div class="content-item {{ $announcement->is_pinned ? 'is-pinned' : '' }}">
                <div class="content-main">
                    <a href="{{ route('announcements.show', $announcement) }}" class="content-title">
                        @if($announcement->is_pinned)
                            <span class="pin-mark">重要</span>
                        @endif
                        {{ $announcement->title }}
                    </a>
                    <div class="content-meta">
                        {{ $announcement->user->name }}／{{ $announcement->created_at->format('Y/m/d') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection