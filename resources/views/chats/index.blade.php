@extends('layouts.app')

@section('title', '社内チャット')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/chats.css') }}">
@endpush

@section('content')

<h2>社内チャット</h2>

@if($users->isEmpty())
    <p>他の社員が登録されていません。</p>
@else
    <div class="chat-users">
        @foreach($users as $user)
            @php
                $unread = $unreadCounts[$user->id] ?? 0;
                $latest = $latestMessages[$user->id] ?? null;
            @endphp

            <div class="chat-user {{ $unread ? 'has-unread' : '' }}">
                <div class="chat-avatar">{{ mb_substr($user->name, 0, 1) }}</div>

                <div class="chat-user-main">
                    <a href="{{ route('chats.show', $user) }}" class="chat-user-name">
                        {{ $user->name }}
                    </a>
                    <div class="chat-preview">
                        {{ $latest ? $latest->body : 'まだメッセージはありません' }}
                    </div>
                </div>

                <div class="chat-side">
                    @if($latest)
                        <div class="chat-user-time">{{ $latest->created_at->format('n/j H:i') }}</div>
                    @endif
                    @if($unread)
                        <span class="unread-badge">{{ $unread }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection