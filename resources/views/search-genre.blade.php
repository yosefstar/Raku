@extends('layouts.app')



@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Genres</title>
</head>

<body>
    <h1>Genres</h1>
    <ul>
        @foreach ($genres as $genre)
        <li>{{ $genre }}</li>
        @endforeach
    </ul>
</body>

<h1>Categories</h1>
<ul>
    @foreach ($categories as $category)
    <li>{{ $category }}</li>
    @endforeach
</ul>

</html>

<h3>FW・MW・ツール等</h3>
<ul>
    <li>Laravel</li>
    <li>git</li>
    <li>jQuery</li>
</ul>

<h3>機能紹介</h3>
<ul>
    <li>ユーザー登録、ログイン認証機能</li>
    <li>楽天市場の商品検索</li>
    <li>お気に入り, 持っている された商品の一覧表示</li>
    <li>お気に入り, 持っている された商品の数でランキング表示</li>
    <li>楽天 API を使用したカテゴリー分類</li>
    <li>商品の除外機能</li>
    <li>JavaScript の Fetch 関数を利用した非同期通信</li>
</ul>
</body>

@endsection