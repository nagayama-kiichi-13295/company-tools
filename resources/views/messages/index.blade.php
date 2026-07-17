@extends('layouts.app')
@section('title', 'チャット')
@section('content')

<h2>チャット:{{ $product->name }}</h2>
<p>
    <a href="{{ route('products.show', $product) }}">商品詳細へ戻る</a>
</p>

@if($messages->isEmpty())
    <p>まだメッセージはありません。</p>
@else
    <div>
        @foreach($messages as $message)
            <div style="margin-bottom: 10px;">
                <strong>{{ $message->user->name }}</strong>
                <span style="color: gray; font-size: 0.8em;">
                    {{ $message->created_at->format('Y/m/d H:i') }}
                </span>
                <div>{{ $message->body }}</div>
            </div>
        @endforeach
    </div>
@endif

<hr>

@if ($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('messages.store', $product) }}" method="post">
    @csrf
    <textarea name="body" rows="3" cols="40">{{ old('body') }}</textarea>
    <br>
    <button type="submit">送信</button>
</form>

@endsection