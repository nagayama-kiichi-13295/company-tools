@extends('layouts.app')

@section('title', 'お気に入り')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')

<h2>お気に入り一覧</h2>

@if($products->isEmpty())
    <p>お気に入りに登録した商品はありません。</p>
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

                    <div class="product-price">{{ number_format($product->price) }} 円</div>

                    <div class="product-meta">
                        {{ $product->category->name ?? '未分類' }}／{{ $product->user->name }}
                    </div>
                </div>

                <div class="product-footer">
                    <form action="{{ route('favorites.toggle', $product) }}" method="post">
                        @csrf
                        <button type="submit" class="btn-fav is-active">★ 解除</button>
                    </form>
                </div>

            </div>
        @endforeach
    </div>
@endif

<a href="{{ route('products.index') }}" class="back-link">← 商品一覧へ戻る</a>

@endsection