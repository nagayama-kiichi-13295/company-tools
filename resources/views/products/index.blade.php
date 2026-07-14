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

@if($products->isEmpty())
    <p>商品はまだありません</p>
@else
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>商品名</th>
            <th>価格</th>
            <th>出品者</th>
        </tr>

        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>

                <td>
                    <a href="{{ route('products.show', $product) }}">
                        {{ $product->name}}
                    </a>
                </td>

                <td>{{ number_format($product->price) }} 円</td>
                <td>{{ $product->user->name }}</td>
            </tr>
        @endforeach

    </table>
@endif

@endsection