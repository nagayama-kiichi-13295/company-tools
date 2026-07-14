@extends('layouts.app')

@section('title', '商品詳細')

@section('content')

<h2>商品詳細</h2>

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
        <th>出品者</th>
        <td>{{ $product->user->name }}</td>
    </tr>
    <tr>
        <th>登録日時</th>
        <td>{{ $product->created_at->format('Y/m/d H:i') }}</td>
    </tr>
</table>

<br>

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