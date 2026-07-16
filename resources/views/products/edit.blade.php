@extends('layouts.app')

@section('title', '商品編集')

@section('content')

<h2>商品編集</h2>

@if ($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>商品名</label><br>
        <input
            type="text"
            name="name"
            value="{{ old('name', $product->name) }}"
        >
    </div>
    <br>
    <div>
        <label>商品説明</label><br>
        <textarea
            name="description"
            rows="5"
        >{{ old('description', $product->description) }}</textarea>
    </div>
    <br>
    <div>
        <label>価格</label><br>
        <input
            type="number"
            name="price"
            value="{{ old('price', $product->price) }}"
        >
    </div>
    <br>
    <dev>
        <label>商品画像</label><br>
        @if($product->image_path)
            <img src="{{ asset('storage/' . $product->image_path) }}" width="150"><br>
        @endif
        <input type="file" name="image" accept="image/*">
    </dev>
    <br>
    <button type="submit">
        更新する
    </button>
</form>

@endsection