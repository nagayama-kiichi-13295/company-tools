@extends('layouts.app')

@section('title', '商品詳細')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')

<h2>商品詳細</h2>

@if(session('success'))
    <p class="flash-success">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p class="flash-error">{{ session('error') }}</p>
@endif

<div class="product-detail">

    {{-- 左：画像 --}}
    <div class="detail-image">
        @if($product->image_path)
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
        @else
            <div class="no-image">画像なし</div>
        @endif
    </div>

    {{-- 右：情報 --}}
    <div class="detail-info">

        <span class="badge badge-{{ $product->status }}">
            {{ $product->statusLabel() }}
        </span>

        <div class="detail-title">{{ $product->name }}</div>

        <div class="detail-price">{{ number_format($product->price) }} 円</div>

        <div class="detail-desc">{{ $product->description }}</div>

        <dl class="detail-meta">
            <div>
                <dt>カテゴリ</dt>
                <dd>{{ $product->category->name ?? '未分類' }}</dd>
            </div>
            <div>
                <dt>出品者</dt>
                <dd>{{ $product->user->name }}</dd>
            </div>
            @if($product->buyer_id)
                <div>
                    <dt>購入者</dt>
                    <dd>{{ $product->buyer->name }}</dd>
                </div>
            @endif
            <div>
                <dt>出品日</dt>
                <dd>{{ $product->created_at->format('Y/m/d H:i') }}</dd>
            </div>
        </dl>

        {{-- 操作ボタン --}}
        <div class="detail-actions">

            {{-- 購入：自分以外の商品で、募集中のときだけ --}}
            @if($product->user_id !== auth()->id() && $product->status === 'available')
                <form action="{{ route('products.purchase', $product) }}" method="post"
                      onsubmit="return confirm('この商品を購入しますか?');">
                    @csrf
                    <button type="submit" class="btn-purchase">購入する</button>
                </form>
            @endif

            {{-- 完了：出品者か購入者で、取引中のときだけ --}}
            @if(($product->user_id === auth()->id() || $product->buyer_id === auth()->id()) && $product->status === 'trading')
                <form action="{{ route('products.complete', $product) }}" method="post"
                      onsubmit="return confirm('取引を完了しますか?');">
                    @csrf
                    <button type="submit" class="btn-complete">取引完了にする</button>
                </form>
            @endif

            {{-- チャット：購入者がいて、自分が当事者のときだけ --}}
            @if($product->buyer_id && ($product->user_id === auth()->id() || $product->buyer_id === auth()->id()))
                <a href="{{ route('messages.index', $product) }}" class="btn-chat">チャットを開く</a>
            @endif

            {{-- お気に入り --}}
            <form action="{{ route('favorites.toggle', $product) }}" method="post">
                @csrf
                <button type="submit" class="btn-fav {{ $isFavorite ? 'is-active' : '' }}">
                    {{ $isFavorite ? '★ お気に入り解除' : '☆ お気に入り登録' }}
                </button>
            </form>

        </div>

        {{-- 出品者だけの操作 --}}
        @if(auth()->id() === $product->user_id)
            <div class="owner-actions">
                <a href="{{ route('products.edit', $product) }}" class="btn-edit">編集する</a>

                <form action="{{ route('products.destroy', $product) }}" method="post"
                      onsubmit="return confirm('本当に消しますか?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">削除する</button>
                </form>
            </div>
        @endif

    </div>
</div>

<a href="{{ route('products.index') }}" class="back-link">← 商品一覧へ戻る</a>

@endsection