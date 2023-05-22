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
        <li>
            {{ $item['Item']['itemName'] }}
            @if(isset($item['Item']['mediumImageUrls']))
                <ul>
                    @foreach($item['Item']['mediumImageUrls'] as $imageUrl)
                        <li><img src="{{ $imageUrl['imageUrl'] }}" alt="商品画像"></li>
                    @endforeach
                </ul>
            @endif
            <p>itemCode: {{ $item['Item']['itemCode'] }}</p> <!-- 追加 -->

            <form action="{{ route('saveItemCode') }}" method="POST"> <!-- 追加 -->
                        @csrf <!-- 追加 -->
                        <input type="hidden" name="itemCode" value="{{ $item['Item']['itemCode'] }}"> <!-- 追加 -->
                        <button type="submit">アイテムコードを保存</button> <!-- 追加 -->
            </form> <!-- 追加 -->
        </li>
        @endforeach
    </ul>
    @endif




@endsection
