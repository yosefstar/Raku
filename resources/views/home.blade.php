@extends('layouts.app')

@section('content')
<div class="container">
    <!-- #この部分です。 -->
    <h1>Categories</h1>
    <ul>
        @foreach ($categories as $category)
        <li>{{ $category }}</li>
        @endforeach
    </ul>
    <!-- #この部分です。 -->

    @foreach($items as $item)
    <div class="item-box">
        <div class="item-image-box">

            <img src="{{ $item->imageUrl }}" alt="商品画像" class="item-image">

        </div>
        <div class="item-box-main">
            <a href="{{ $item->itemUrl }}" target="_blank">
                <p class="item-name">商品名: {{ $item->itemName }}</p>
            </a>
            <p>ジャンル:{{ $item->genreName }}</p>
            <p>価格: {{ number_format(intval($item->itemPrice)) }}円</p>


            <!-- <form action="{{ route('wantItem') }}" method="POST"> -->
            <div class="button-arrange">
                @if (in_array($item['itemCode'], $wantLists))
                <button type="submit" class="wantbutton custom-style-want" data-itemcode="{{ $item->itemCode }}" data-itemprice="{{ $item->itemPrice }}" data-image-url="{{ $item->imageUrl }}" data-item-name="{{ $item->itemName }}" data-item-url="{{ $item->itemUrl }}">お気に入り</button>
                @else
                <button type="submit" class="wantbutton" data-itemcode="{{ $item->itemCode }}" data-itemprice="{{ $item->itemPrice }}" data-image-url="{{ $item->imageUrl }}" data-item-name="{{ $item->itemName }}" data-item-url="{{ $item->itemUrl }}">お気に入りに追加</button>
                @endif

                @if (in_array($item['itemCode'], $haveLists))
                <button type="submit" class="havebutton custom-style-have" data-itemcode="{{ $item->itemCode }}" data-itemprice="{{ $item->itemPrice }}" data-image-url="{{ $item->imageUrl }}" data-item-name="{{ $item->itemName }}" data-item-url="{{ $item->itemUrl }}">持っている</button>
                @else
                <button type="submit" class="havebutton" data-itemcode="{{ $item->itemCode }}" data-itemprice="{{ $item->itemPrice }}" data-image-url="{{ $item->imageUrl }}" data-item-name="{{ $item->itemName }}" data-item-url="{{ $item->itemUrl }}">持っているに追加</button>



                @endif
            </div>
            @csrf
            <input type="hidden" name="imageUrl" value="{{ $item->imageUrl }}">
            <input type="hidden" name="itemName" value="{{ $item->itemName }}">
            <input type="hidden" name="itemPrice" value="{{ $item->itemPrice }}">
            <input type="hidden" name="itemUrl" value="{{ $item->itemUrl }}">
            <input type="hidden" name="itemCode" value="{{ $item->itemCode }}">
            <input type="hidden" id="userId" value="{{ auth()->user()->id }}">


            <!-- </form> -->
        </div>
    </div>
    @endforeach
    <!-- </div> -->
    <!-- </div> -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.havebutton').on('click', function() {
            const have = "持っている";
            const notHave = "持っているに追加";
            let haveStatus = $(this).data('havestatus');
            const itemCode = $(this).data('itemcode');
            const itemPrice = $(this).data('itemprice');
            const userId = document.getElementById('userId').value;
            const imageUrl = $(this).data('imageUrl');
            const itemName = $(this).data('itemName');
            const itemUrl = $(this).data('itemUrl');




            if ($(this).text() == have) {
                $(this).text(notHave);
                haveStatus = 0;

            } else {
                $(this).text(have);
                haveStatus = 1;

            }

            fetch("/have-item", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}", // LaravelでCSRF保護を使用している場合に必要
                    },
                    body: JSON.stringify({
                        userId: userId,
                        itemCode: itemCode,
                        haveStatus: haveStatus,
                        imageUrl: imageUrl,
                        itemName: itemName,
                        itemPrice: itemPrice,
                        itemUrl: itemUrl
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

    $(function() {
        $('.wantbutton').on('click', function() {
            const want = "お気に入り";
            const notWant = "お気に入りに追加";
            let wantStatus = $(this).data('wantstatus');
            const itemCode = $(this).data('itemcode');
            const itemPrice = $(this).data('itemprice');
            const userId = document.getElementById('userId').value;
            const imageUrl = $(this).data('imageUrl');
            const itemName = $(this).data('itemName');
            const itemUrl = $(this).data('itemUrl');







            // console.log("{{ route('api.update_want_status') }}");

            if ($(this).text() == want) {
                $(this).text(notWant);
                wantStatus = 0;
                console.log("これがwantStatus", wantStatus);
            } else {
                $(this).text(want);
                wantStatus = 1;
                console.log("これがwantStatus", wantStatus);
            }

            fetch("/want-item", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}", // LaravelでCSRF保護を使用している場合に必要
                    },
                    body: JSON.stringify({
                        userId: userId,
                        itemCode: itemCode,
                        wantStatus: wantStatus,
                        imageUrl: imageUrl,
                        itemName: itemName,
                        itemPrice: itemPrice,
                        itemUrl: itemUrl
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



@endsection