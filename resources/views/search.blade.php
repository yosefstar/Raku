@extends('layouts.app')

@section('content')
<div class="search-box">
    @if (isset($errorMessage))
    <p>{{ $errorMessage }}</p>
    @endif
    <h1>検索画面</h1>

    <form action="{{ route('search.index') }}" method="GET">
        <input type="text" name="keyword" placeholder="キーワードを入力">
        <button type="submit">検索</button>
    </form>

    @if(isset($items))

    <h2>検索結果</h2>
    <p>合計 {{ $count }} 件の商品が見つかりました。</p>
    <ul>
</div>
@foreach($items as $item)
<div class="item-box">
    <!-- アイテム情報表示 -->
    <div class="item-image-box">
        <img src="{{ $item['Item']['mediumImageUrls'][0]['imageUrl'] }}" alt="商品画像" class="item-image">
    </div>
    <div class="item-box-main">
        <a href="{{ $item['Item']['itemUrl'] }}">
            <p>商品名:{{ $item['Item']['itemName'] }}</p>
        </a>
        <p>価格: {{ number_format(intval($item['Item']['itemPrice'])) }}円</p>
        <div class="button-arrange">
            @if (in_array($item['Item']['itemCode'], $myItemLists->pluck('itemCode')->all()))
            <button type="submit" class="wantbutton custom-style-want" data-itemcode="{{ $item['Item']['itemCode'] }}" data-itemprice="{{ $item['Item']['itemPrice'] }}" data-image-url="{{ $item['Item']['mediumImageUrls'][0]['imageUrl'] }}" data-item-name="{{ $item['Item']['itemName'] }}" data-item-url="{{ $item['Item']['itemUrl'] }}">追加済み</button>
            @else
            <button type="button" class="addbutton" data-itemcode="{{ $item['Item']['itemCode'] }}" data-itemprice="{{ $item['Item']['itemPrice'] }}" data-image-url="{{ $item['Item']['mediumImageUrls'][0]['imageUrl'] }}" data-item-name="{{ $item['Item']['itemName'] }}" data-item-url="{{ $item['Item']['itemUrl'] }}">アイテムを追加</button>
            @endif
        </div>


        <!-- @csrf
        <input type="hidden" name="imageUrl" value="{{ $item['Item']['mediumImageUrls'][0]['imageUrl'] }}">
        <input type="hidden" name="itemName" value="{{ $item['Item']['itemName'] }}">
        <input type="hidden" name="itemPrice" value="{{ $item['Item']['itemPrice'] }}">
        <input type="hidden" name="itemUrl" value="{{ $item['Item']['itemUrl'] }}">
        <input type="hidden" name="itemCode" value="{{ $item['Item']['itemCode'] }}"> -->
        <input type="hidden" id="userId" value="{{ auth()->user()->id }}">
    </div>
</div>
@endforeach


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.addbutton').on('click', function() {
            const add = "Add";
            const added = "Added";
            let itemStatus = $(this).data('itemstatus');
            const itemCode = $(this).data('itemcode');
            const itemPrice = $(this).data('itemprice');
            const userId = document.getElementById('userId').value;
            const imageUrl = $(this).data('imageUrl');
            const itemName = $(this).data('itemName');
            const itemUrl = $(this).data('itemUrl');
            console.log(itemUrl);
            console.log(itemName);
            console.log(imageUrl);
            console.log(userId);
            console.log(itemPrice);
            console.log(itemCode);
            console.log(itemStatus);

            if ($(this).text() == "アイテムを追加") {
                $(this).text("追加済み");
                itemStatus = 0;
            } else {
                $(this).text("アイテムを追加");
                itemStatus = 1;
            }

            fetch("/save-itemcode", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}", // LaravelでCSRF保護を使用している場合に必要
                    },
                    body: JSON.stringify({
                        userId: userId,
                        itemCode: itemCode,
                        imageUrl: imageUrl,
                        itemName: itemName,
                        itemPrice: itemPrice,
                        itemUrl: itemUrl,
                        itemStatus: itemStatus,
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    // レスポンスを処理
                    console.log(data);
                })
                .catch((error) => {
                    console.error("エラー:", error);
                });
            return false;
        });
    });
</script>





</ul>
@endif





@endsection