@extends('layouts.app')

@section('title', '商品詳細')

@section('content')

<h2>商品詳細</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>商品名</th>
        <td>{{ $product->name }}</td>
    </tr>
    <tr>
        <th>商品説明</th>
        <td>{{ $product->description }}</td>
    </tr>
    <tr>
        <th>価格</th>
        <td>{{ $product->price }}</td>
    </tr>
    <tr>
        <th>商品画像</th>
        <td>
            @if($product->image_path)
                <img src="{{ asset('storage/' . $product->image_path) }}" width="200">
            @else
                画像なし
            @endif
        </td>
    </tr>
    <tr>
        <th>出品者</th>
        <td>{{ $product->user->name }}</td>
    </tr>
    <tr>
        <th>登録日時</th>
        <td>{{ $product->created_at->format('Y/m/d H:i') }}</td>
    </tr>
</table>

<br>

<!-- 購入者ボタン：自分以外の商品で、募集中の時だけ -->
@if($product->user_id !== auth()->id() && $product->status === 'available')
    <form action="{{ route('products.purchase', $product) }}" method="post"
          onsubmit="return confirm('この商品を購入しますか?');">
        @csrf
        <button type="submit">購入する</button>
    </form>
    <br>
@endif

<!-- 完了ボタン:出品者か購入者で、取引中の時だけ -->
@if(($product->user_id === auth()->id() || $product->buyer_id === auth()->id()) && $product->status === 'trading')
    <form action="{{ route('products.complete', $product) }}" method="post"
          onsubmit="return confirm('取引を完了しますか?')">
        @csrf
        <button type="submit">取引完了にする</button>
    </form>
    <br>
@endif

<!-- チャット:購入者がいて、自分が出品者か購入者のときだけ -->
@if($product->buyer_id && ($product->user_id === auth()->id() || $product->buyer_id === auth()->id()))
    <a href="{{ route('messages.index', $product) }}">チャットを開く</a>
    <br><br>
@endif

@if(auth()->id() === $product->user_id)
    <br><br>

    <a href="{{ route('products.edit', $product) }}">
        編集する
    </a>

    <br><br>

    <form
        action="{{ route('products.destroy', $product) }}"
        method="post"
        onsubmit="return confirm('本当に消しますか?');"
    >
        @csrf
        @method('DELETE')

        <button type="submit">
            削除する
        </button>
    </form>
@endif

<br>

<a href="{{ route('products.index') }}">
    商品一覧へ戻る
</a>

@endsection