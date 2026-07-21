@extends('layouts.app')

@section('title', 'チャット')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">
@endpush

@section('content')

<h2>チャット</h2>

<div class="chat-header">
    <div>
        <strong>{{ $product->name }}</strong>
        <span class="badge badge-{{ $product->status }}">{{ $product->statusLabel() }}</span>
    </div>
    <a href="{{ route('products.show', $product) }}" class="product-link">商品詳細へ戻る</a>
</div>

<div class="chat-log">
    @forelse($messages as $message)
        <div class="chat-row {{ $message->user_id === auth()->id() ? 'is-mine' : 'is-other' }}">
            <div class="chat-name">{{ $message->user->name }}</div>
            <div class="chat-bubble">{{ $message->body }}</div>
            <div class="chat-time">{{ $message->created_at->format('Y/m/d H:i') }}</div>
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

<form action="{{ route('messages.store', $product) }}" method="post" class="chat-form">
    @csrf
    <textarea name="body" rows="3" placeholder="メッセージを入力">{{ old('body') }}</textarea>
    <button type="submit">送信</button>
</form>

@endsection