@extends('layouts.app')

@section('title', $user->name . ' とのチャット')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chats.css') }}">
@endpush

@section('content')

<h2>社内チャット</h2>

<div class="dm-header">
    <div class="chat-avatar">{{ mb_substr($user->name, 0, 1) }}</div>
    <div class="dm-header-name">{{ $user->name }}</div>
    <a href="{{ route('chats.index') }}">チャット一覧へ戻る</a>
</div>

<div class="chat-log">
    @forelse($messages as $message)
        <div class="chat-row {{ $message->sender_id === auth()->id() ? 'is-mine' : 'is-other' }}">
            <div class="chat-bubble">{{ $message->body }}</div>
            <div class="chat-time">
                {{ $message->created_at->format('n/j H:i') }}
                @if($message->sender_id === auth()->id() && $message->read_at)
                    ・既読
                @endif
            </div>
        </div>
    @empty
        <p class="chat-empty">まだメッセージはありません。</p>
    @endforelse
</div>

@if($errors->any())
    <ul class="error-list">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('chats.store', $user) }}" method="post" class="chat-form">
    @csrf
    <textarea name="body" rows="3" placeholder="メッセージを入力">{{ old('body') }}</textarea>
    <button type="submit">送信</button>
</form>

@endsection