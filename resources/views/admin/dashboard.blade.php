@extends('layouts.app')
@section('title', '管理者ダッシュボード')
@section('content')

<h2>管理者ダッシュボード</h2>

<h3>全体の利用状況</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>登録ユーザ数</th>
        <td>{{ $userCount }} 人</td>
    </tr>
    <tr>
        <th>出品数</th>
        <td>{{ $productCount }} 件</td>
    </tr>
    <tr>
        <th>お知らせ数</th>
        <td>{{ $announcementCount }} 件</td>
    </tr>
    <tr>
        <th>イベント数</th>
        <td>{{ $eventCount }} 件</td>
    </tr>
</table>

<br>

<h3>取引状況</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>募集中</th>
        <td>{{ $statusCounts['available'] ?? 0 }} 件</td>
    </tr>
    <tr>
        <th>取引中</th>
        <td>{{ $statusCounts['trading'] ?? 0 }} 件</td>
    </tr>
    <tr>
        <th>完了</th>
        <td>{{ $statusCounts['complete'] ?? 0 }} 件</td>
    </tr>
</table>

<br>

<h3>カテゴリ別の出品数</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>カテゴリ</th>
        <th>出品数</th>
    </tr>
    @foreach($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->products_count }} 件</td>
        </tr>
    @endforeach
</table>

<br>

<h3>最近の出品</h3>
@if($recentProducts->isEmpty())
    <p>出品はまだありません</p>
@else
    <table border="1" cellpadding="10">
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
                <td>{{ $product->statusLabel() }}</td>
                <td>{{ $product->created_at->format('Y/m/d') }}</td>
            </tr>
        @endforeach
    </table>
@endif

@endsection

