@extends('layouts.app')

@section('title', '管理者ダッシュボード')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')

<h2>管理者ダッシュボード</h2>

<p class="section-title">全体の利用状況</p>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">登録ユーザー</div>
        <div class="stat-value">{{ $userCount }}<span class="stat-unit">人</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">出品数</div>
        <div class="stat-value">{{ $productCount }}<span class="stat-unit">件</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">お知らせ</div>
        <div class="stat-value">{{ $announcementCount }}<span class="stat-unit">件</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">イベント</div>
        <div class="stat-value">{{ $eventCount }}<span class="stat-unit">件</span></div>
    </div>
</div>

<p class="section-title">取引状況</p>

<div class="stat-grid">
    <div class="stat-card is-available">
        <div class="stat-label">募集中</div>
        <div class="stat-value">{{ $statusCounts['available'] ?? 0 }}<span class="stat-unit">件</span></div>
    </div>
    <div class="stat-card is-trading">
        <div class="stat-label">取引中</div>
        <div class="stat-value">{{ $statusCounts['trading'] ?? 0 }}<span class="stat-unit">件</span></div>
    </div>
    <div class="stat-card is-completed">
        <div class="stat-label">完了</div>
        <div class="stat-value">{{ $statusCounts['completed'] ?? 0 }}<span class="stat-unit">件</span></div>
    </div>
</div>

<p class="section-title">カテゴリ別の出品数</p>

<div class="bar-list">
    @foreach($categories as $category)
        <div class="bar-row">
            <span class="bar-name">{{ $category->name }}</span>
            <span class="bar-track">
                <span class="bar-fill"
                      style="width: {{ round($category->products_count / $maxCategoryCount * 100) }}%"></span>
            </span>
            <span class="bar-count">{{ $category->products_count }} 件</span>
        </div>
    @endforeach
</div>

<p class="section-title">最近の出品</p>

@if($recentProducts->isEmpty())
    <p>出品はまだありません。</p>
@else
    <table>
        <tr>
            <th>商品名</th>
            <th>出品者</th>
            <th>状態</th>
            <th>出品日</th>
        </tr>
        @foreach($recentProducts as $product)
            <tr>
                <td>
                    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                </td>
                <td>{{ $product->user->name }}</td>
                <td>
                    <span class="badge badge-{{ $product->status }}">{{ $product->statusLabel() }}</span>
                </td>
                <td>{{ $product->created_at->format('Y/m/d') }}</td>
            </tr>
        @endforeach
    </table>
@endif

@endsection