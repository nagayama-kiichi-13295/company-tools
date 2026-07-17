@extends('layouts.app')

@section('title', '商品一覧')

@section('content')

<h2>商品一覧</h2>
@if(session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif

<p>
    <a href="{{ route('products.create') }}">商品を出品する</a>
</p>

<!-- 検索フォーム -->
 <form action="{{ route('products.index') }}" method="get">
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
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>画像</th>
            <th>商品名</th>
            <td>カテゴリ</td>
            <th>価格</th>
            <th>状態</th>
            <th>出品者</th>
            <th>お気に入り</th>
        </tr>

        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>

                <td>
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" width="80">
                    @else
                        なし
                    @endif
                </td>

                <td>
                    <a href="{{ route('products.show', $product) }}">
                        {{ $product->name}}
                    </a>
                </td>

                <td>{{ $product->category->name ?? '未分類' }}</td>
                <td>{{ number_format($product->price) }} 円</td>
                <td>{{ $product->statusLabel() }}</td>
                <td>{{ $product->user->name }}</td>
                <td>
                    <form action="{{ route('favorites.toggle', $product) }}" method="post">
                        @csrf
                        @if(in_array($product->id, $favoriteIds))
                            <button type="submit">★ 解除</button>
                        @else
                            <button type="submit">☆ 登録</button>
                        @endif
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endif

@endsection