@extends('layouts.app')

@section('content')
    <h1>検索画面</h1>

    <form action="{{ route('search.index') }}" method="GET">
        <input type="text" name="keyword" placeholder="キーワードを入力">
        <button type="submit">検索</button>
    </form>

    @if(isset($items))
    <h2>検索結果</h2>
    <p>合計 {{ $count }} 件の商品が見つかりました。</p>
    <ul>
    @foreach($items as $item)
    <div>
        <!-- アイテム情報表示 -->
        <img src="{{ $item['Item']['mediumImageUrls'][0]['imageUrl'] }}" alt="商品画像">
        <p>商品名: {{ $item['Item']['itemName'] }}</p>
        <p>価格: {{ $item['Item']['itemPrice'] }}</p>
        <a href="{{ $item['Item']['itemUrl'] }}">商品ページへ</a>

        <form action="{{ route('saveItemCode') }}" method="POST">
            @csrf
            <input type="hidden" name="imageUrl" value="{{ $item['Item']['mediumImageUrls'][0]['imageUrl'] }}">
            <input type="hidden" name="itemName" value="{{ $item['Item']['itemName'] }}">
            <input type="hidden" name="itemPrice" value="{{ $item['Item']['itemPrice'] }}">
            <input type="hidden" name="itemUrl" value="{{ $item['Item']['itemUrl'] }}">
            <input type="hidden" name="itemCode" value="{{ $item['Item']['itemCode'] }}">
            <button type="submit">アイテムを追加</button>
        </form>
    </div>
@endforeach




    </ul>
    @endif




@endsection
