@extends('layouts.app')
@section('title', 'お気に入り')
@section('content')

<h2>お気に入り一覧</h2>

<p>
    <a href="{{ route('products.index') }}">商品一覧へ戻る</a>
</p>

@if($products->isEmpty())
    <p>お気に入りに登録した商品はありません。</p>
@else
    <table border="1" cellpadding="10">
        <tr>
            <th>画像</th>
            <th>商品名</th>
            <th>カテゴリ</th>
            <th>価格</th>
            <th>状態</th>
        </tr>

        @foreach($products as $product)
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

@endsection