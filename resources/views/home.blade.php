@extends('layouts.app')

@section('title', 'ホーム')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

<div class="welcome">
    <div class="welcome-name">ようこそ、{{ Auth::user()->name }} さん</div>
    <div class="welcome-date">{{ now()->format('Y年n月j日') }}</div>
</div>

{{-- お知らせ --}}
<div class="home-section">
    <div class="home-head">
        <h3>お知らせ</h3>
        <a href="{{ route('announcements.index') }}">すべて見る</a>
    </div>

    @if($announcements->isEmpty())
        <p class="home-empty">お知らせはありません。</p>
    @else
        <div class="home-list">
            @foreach($announcements as $announcement)
                <div class="home-row {{ $announcement->is_pinned ? 'is-pinned' : '' }}">
                    <div class="home-row-main">
                        <a href="{{ route('announcements.show', $announcement) }}" class="home-row-title">
                            @if($announcement->is_pinned)
                                <span class="pin-mark">重要</span>
                            @endif
                            {{ $announcement->title }}
                        </a>
                        <div class="home-row-sub">{{ $announcement->user->name }}</div>
                    </div>
                    <div class="home-date">{{ $announcement->created_at->format('n/j') }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- イベント --}}
<div class="home-section">
    <div class="home-head">
        <h3>今後のイベント</h3>
        <a href="{{ route('events.index') }}">すべて見る</a>
    </div>

    @if($events->isEmpty())
        <p class="home-empty">予定されているイベントはありません。</p>
    @else
        <div class="home-list">
            @foreach($events as $event)
                <div class="home-row">
                    <div class="home-row-main">
                        <a href="{{ route('events.show', $event) }}" class="home-row-title">
                            {{ $event->title }}
                        </a>
                        <div class="home-row-sub">参加 {{ $event->participants_count }} 人</div>
                    </div>
                    <div class="home-date">{{ $event->held_at->format('n/j H:i') }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- 新着出品 --}}
<div class="home-section">
    <div class="home-head">
        <h3>新着の出品</h3>
        <a href="{{ route('products.index') }}">すべて見る</a>
    </div>

    @if($products->isEmpty())
        <p class="home-empty">出品はありません。</p>
    @else
        <div class="home-products">
            @foreach($products as $product)
                <div class="home-product">
                    <a href="{{ route('products.show', $product) }}" class="home-product-thumb">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                        @else
                            <span class="no-image">画像なし</span>
                        @endif
                    </a>
                    <div class="home-product-body">
                        <a href="{{ route('products.show', $product) }}" class="home-product-name">
                            {{ $product->name }}
                        </a>
                        <div class="home-product-price">{{ number_format($product->price) }} 円</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection