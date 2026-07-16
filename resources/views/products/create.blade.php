@extends('layouts.app')

@section('title', '商品出品')

@section('content')

<h2>商品出品</h2>

@if ($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div>
        <label>商品名</label><br>
        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
        >
    </div>
    <br>
    <div>
        <label>商品説明</label><br>
        <textarea
            name="description"
            rows="5"
        >{{ old('description') }}</textarea>
    </div>
    <br>
    <div>
        <label>価格</label><br>
        <input
            type="number"
            name="price"
            value="{{ old('price') }}"
        >
    </div>
    <br>
    <div>
        <label>商品画像</label><br>
        <input type="file" name="image" accept="image/*">
    </div>
    <br>
    <button type="submit">
        出品する
    </button>

</form>

@endsection