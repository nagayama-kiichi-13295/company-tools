@extends('layouts.app')

@section('title', '新規登録')

@section('content')

@if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('register') }}" method="post">
    @csrf

    <div>
        <label for="name">名前</label><br>
        <input 
            type="text" 
            id="name"
            name="name" 
            value="{{ old('name') }}"
        >
    </div>

    <br>

    <div>
        <label for="email">メールアドレス</label><br>
        <input 
            type="email" 
            id="email"
            name="email" 
            value="{{ old('email') }}"
        >
    </div>

    <br>

    <div>
        <label for="password">パスワード</label><br>
        <input 
            type="password" 
            id="password"
            name="password"
            required
        >
    </div>

    <br>

    <div>
        <label for="password_confirmation">パスワード確認</label><br>
        <input 
            type="password" 
            id="password_confirmation"
            name="password_confirmation"
            required
        >
    </div>

    <br>

    <button type="submit">
        登録
    </button>
</form>

<p>
    <a href="{{ route('login') }}">ログインはこちら</a>
</p>

@endsection