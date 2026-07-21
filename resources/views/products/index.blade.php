@extends('layouts.app')

@section('title', '商品一覧')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')

<h2>商品一覧</h2>

@if(session('success'))
    <p class="flash-success">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p class="flash-error">{{ session('error') }}</p>
@endif

<p>
    <a href="{{ route('products.create') }}">商品を出品する</a>
</p>

{{-- 検索フォーム --}}
<form action="{{ route('products.index') }}" method="get" class="search-bar">
    <input type="text" name="keyword" value="{{ $keyword }}" placeholder="キーワード">

    <select name="category_id">
        <option value="">すべてのカテゴリ</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ $categoryId == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <button type="submit">検索</button>
    <a href="{{ route('products.index') }}">リセット</a>
</form>

@if($products->isEmpty())
    <p>該当する商品はありません</p>
@else
    <p class="result-count">{{ $products->count() }} 件の商品</p>

    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card">

                <a href="{{ route('products.show', $product) }}" class="product-thumb">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                    @else
                        <span class="no-image">画像なし</span>
                    @endif
                </a>

                <div class="product-body">
                    <span class="badge badge-{{ $product->status }}">
                        {{ $product->statusLabel() }}
                    </span>

                    <a href="{{ route('products.show', $product) }}" class="product-name">
                        {{ $product->name }}
                    </a>

                    <div class="product-price">
                        {{ number_format($product->price) }} 円
                    </div>

                    <div class="product-meta">
                        {{ $product->category->name ?? '未分類' }}／{{ $product->user->name }}
                    </div>
                </div>

                <div class="product-footer">
                    <form action="{{ route('favorites.toggle', $product) }}" method="post">
                        @csrf
                        @if(in_array($product->id, $favoriteIds))
                            <button type="submit" class="btn-fav is-active">★ 解除</button>
                        @else
                            <button type="submit" class="btn-fav">☆ 登録</button>
                        @endif
                    </form>
                </div>

            </div>
        @endforeach
    </div>
@endif

@endsection