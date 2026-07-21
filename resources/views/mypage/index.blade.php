@extends('layouts.app')

@section('title', 'マイページ')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endpush

@section('content')

<h2>マイページ</h2>

<div class="mypage-section">
    <div class="mypage-head">
        <h3>出品した商品</h3>
        <span class="mypage-count">{{ $listedProducts->count() }} 件</span>
    </div>

    @if($listedProducts->isEmpty())
        <p class="mypage-empty">出品した商品はありません。</p>
    @else
        <table>
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
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="thumb-small">
                        @else
                            <div class="thumb-none">なし</div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                    </td>
                    <td>{{ $product->category->name ?? '未分類' }}</td>
                    <td>{{ number_format($product->price) }} 円</td>
                    <td>
                        <span class="badge badge-{{ $product->status }}">{{ $product->statusLabel() }}</span>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
</div>

<div class="mypage-section">
    <div class="mypage-head">
        <h3>購入した商品</h3>
        <span class="mypage-count">{{ $purchasedProducts->count() }} 件</span>
    </div>

    @if($purchasedProducts->isEmpty())
        <p class="mypage-empty">購入した商品はありません。</p>
    @else
        <table>
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
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="thumb-small">
                        @else
                            <div class="thumb-none">なし</div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                    </td>
                    <td>{{ $product->category->name ?? '未分類' }}</td>
                    <td>{{ number_format($product->price) }} 円</td>
                    <td>{{ $product->user->name }}</td>
                    <td>
                        <span class="badge badge-{{ $product->status }}">{{ $product->statusLabel() }}</span>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
</div>

@endsection