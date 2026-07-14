@extends('layouts.app')

@section('title', 'ホーム')

@section('content')

<h2>ホーム</h2>

<p>
    ようこそ、
    <strong>{{ Auth::user()->name }}</strong>
    さん！
</p>

@endsection