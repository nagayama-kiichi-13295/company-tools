@extends('layouts.app')

@section('title', 'ログイン')

@section('content')

<h2>ログイン</h2>
@if($errors->any())
<p style="color: red;">
    {{ $errors->first() }}
</p>
@endif

<form action="/login" method="post">

    @csrf
    <div>
        <label>メールアドレス</label><br>
        <input
            type="email"
            name="email"
            value="{{ old('email') }}">
    </div>

    <br>

    <div>
        <label>パスワード</label><br>
        <input
            type="password"
            name="password">
    </div>

    <br>

    <button type="submit">ログイン</button>
</form>

<br>

<p>
    アカウントお持ちでない方は
    <a href="{{ url('/register') }}">新規登録はこちら</a>
</p>

@endsection