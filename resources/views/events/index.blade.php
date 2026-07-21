@extends('layouts.app')

@section('title', 'イベント')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/contents.css') }}">
@endpush

@section('content')

<h2>イベント</h2>

@if(session('success'))
    <p class="flash-success">{{ session('success') }}</p>
@endif

@can('create', App\Models\Event::class)
    <a href="{{ route('events.create') }}" class="create-link">＋ イベントを作成する</a>
@endcan

@if($events->isEmpty())
    <p>イベントはありません。</p>
@else
    <div class="content-list">
        @foreach($events as $event)
            <div class="content-item">
                <div class="date-box">
                    <div class="date-month">{{ $event->held_at->format('n') }}月</div>
                    <div class="date-day">{{ $event->held_at->format('j') }}</div>
                </div>

                <div class="content-main">
                    <a href="{{ route('events.show', $event) }}" class="content-title">
                        {{ $event->title }}
                    </a>
                    <div class="content-meta">
                        {{ $event->held_at->format('Y/m/d H:i') }} 開催
                    </div>
                </div>

                <div class="join-count">参加 {{ $event->participants_count }} 人</div>
            </div>
        @endforeach
    </div>
@endif

@endsection