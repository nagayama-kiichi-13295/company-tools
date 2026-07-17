@extends('layouts.app')
@section('title', 'マイページ')
@section('content')

<h2>マイページ</h2>

<h3>出品した商品</h3>
@if($listedProducts->isEmpty())
    <p>出品した商品はありません</p>
@else
    <table border="1" cellpadding="10">
        <tr>
            <th>画像</th>
            <th>商品名</th>
            <th>カテゴリ</th>
            <th>価格</th>
            <th>状態</th>
        </tr>
        @foreach($listedProducts as $product)
            <tr>
                <td>
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" width="80">
                    @else
                        なし
                    @endif
                </td>
                <td>
                    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                </td>
                <td>{{ $product->category->name ?? '未分類' }}</td>
                <td>{{ number_format($product->price) }} 円</td>
                <td>{{ $product->statusLabel() }}</td>
            </tr>
        @endforeach
    </table>
@endif

<br>

<h3>購入した商品</h3>
@if($purchasedProducts->isEmpty())
    <p>購入した商品はありません</p>
@else
    <table border="1" cellpadding="10">
        <tr>
            <th>画像</th>
            <th>商品名</th>
            <th>カテゴリ</th>
            <th>価格</th>
            <th>出品者</th>
            <th>状態</th>
        </tr>
        @foreach($purchasedProducts as $product)
            <tr>
                <td>
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" width="80">
                    @else
                        なし
                    @endif
                </td>
                <td>
                    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                </td>
                <td>{{ $product->category->name ?? '未分類' }}</td>
                <td>{{ number_format($product->price) }} 円</td>
                <td>{{ $product->user->name }}</td>
                <td>{{ $product->statusLabel() }}</td>
            </tr>
        @endforeach
    </table>
@endif

@endsection