@extends('layouts.app')

@section('content')
<div class="container">
    <!-- #この部分です。 -->
    <form action="{{ route('home') }}" method="GET" id="categoryForm">
        <h1>カテゴリーから選ぶ</h1>
        <select name="category" id="categorySelect">
            @foreach ($categories as $category)
            <option value="{{ $category }}" {{ $category === $selectedCategory ? 'selected' : '' }}>
                {{ $category }}
            </option>
            @endforeach
        </select>

        <button type="submit">絞り込み</button>
        <button type="button" onclick="location.reload();">全体表示</button>

    </form>

    <script>
        document.getElementById('categoryForm').addEventListener('submit', function(event) {
            event.preventDefault(); // フォームのデフォルトの送信動作をキャンセル

            var categorySelect = document.getElementById('categorySelect');
            var selectedCategory = categorySelect.options[categorySelect.selectedIndex].value;
            console.log(selectedCategory);

            var items = document.getElementsByClassName('item-box');
            for (var i = 0; i < items.length; i++) {
                var itemGenre = items[i].getAttribute('data-genre');
                if (itemGenre !== selectedCategory) {
                    items[i].style.display = 'none'; // 非表示にする
                } else {
                    items[i].style.display = 'inline-block'; // 表示する
                }
            }
        });
    </script>

    @foreach($items as $item)
    <div class="item-box" data-genre="{{ $item->genreName }}">
        <div class="item-image-box">

            <img src="{{ $item->imageUrl }}" alt="商品画像" class="item-image">

        </div>
        <div class="item-box-main">
            <a href="{{ $item->itemUrl }}" target="_blank">
                <p class="item-name">商品名: {{ $item->itemName }}</p>
            </a>
            <p>{{ $item->genreName }}</p>
            <p>価格: {{ number_format(intval($item->itemPrice)) }}円</p>


            <!-- <form action="{{ route('wantItem') }}" method="POST"> -->
            <div class="button-arrange">
                @if (in_array($item['itemCode'], $wantLists))
                <button type="submit" class="wantbutton custom-style-want" data-itemcode="{{ $item->itemCode }}" data-itemprice="{{ $item->itemPrice }}" data-image-url="{{ $item->imageUrl }}" data-item-name="{{ $item->itemName }}" data-item-url="{{ $item->itemUrl }}" data-item-url="{{ $item->genreName }}">お気に入り</button>
                @else
                <button type="submit" class="wantbutton" data-itemcode="{{ $item->itemCode }}" data-itemprice="{{ $item->itemPrice }}" data-image-url="{{ $item->imageUrl }}" data-item-name="{{ $item->itemName }}" data-item-url="{{ $item->itemUrl }}" data-item-url="{{ $item->genreName }}">お気に入りに追加</button>
                @endif

                @if (in_array($item['itemCode'], $haveLists))
                <button type="submit" class="havebutton custom-style-have" data-itemcode="{{ $item->itemCode }}" data-itemprice="{{ $item->itemPrice }}" data-image-url="{{ $item->imageUrl }}" data-item-name="{{ $item->itemName }}" data-item-url="{{ $item->itemUrl }}" data-item-url="{{ $item->genreName }}">持っている</button>
                @else
                <button type="submit" class="havebutton" data-itemcode="{{ $item->itemCode }}" data-itemprice="{{ $item->itemPrice }}" data-image-url="{{ $item->imageUrl }}" data-item-name="{{ $item->itemName }}" data-item-url="{{ $item->itemUrl }}" data-item-url="{{ $item->genreName }}">持っているに追加</button>
                @endif

                @if (in_array($item['itemCode'], $unlikeLists))
                <button type="submit" class="unlikebutton custom-style-have" data-itemcode="{{ $item->itemCode }}" data-itemprice="{{ $item->itemPrice }}" data-image-url="{{ $item->imageUrl }}" data-item-name="{{ $item->itemName }}" data-item-url="{{ $item->itemUrl }}" data-item-url="{{ $item->genreName }}">除外済み</button>
                @else
                <button type="submit" class="unlikebutton" data-itemcode="{{ $item->itemCode }}" data-itemprice="{{ $item->itemPrice }}" data-image-url="{{ $item->imageUrl }}" data-item-name="{{ $item->itemName }}" data-item-url="{{ $item->itemUrl }}" data-item-url="{{ $item->genreName }}">除外する</button>
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
            const genreName = $(this).data('genreName');

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
                        itemUrl: itemUrl,
                        genreName: genreName,
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
            const genreName = $(this).data('genreName');

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
                        itemUrl: itemUrl,
                        genreName: genreName,
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
        $('.unlikebutton').on('click', function() {
            const unlike = "除外する";
            const unliked = "除外済み";
            let unlikeStatus = $(this).data('unlikestatus');
            const itemCode = $(this).data('itemcode');
            const itemPrice = $(this).data('itemprice');
            const userId = document.getElementById('userId').value;
            const imageUrl = $(this).data('imageUrl');
            const itemName = $(this).data('itemName');
            const itemUrl = $(this).data('itemUrl');
            const genreName = $(this).data('genreName');

            // const itemBoxMain = $(this).closest('.item-box').find('.item-box-main'); // 対応するitem-box-mainを取得
            const itemBox = $(this).closest('.item-box');

            if ($(this).text() == unlike) {
                $(this).text(unliked);
                unlikeStatus = 0;
                console.log("これがwantStatus", unlikeStatus);
            } else {
                $(this).text(want);
                unlikeStatus = 1;
                console.log("これがwantStatus", unlikeStatus);
            }

            fetch("/unlike-item", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}", // LaravelでCSRF保護を使用している場合に必要
                    },
                    body: JSON.stringify({
                        userId: userId,
                        itemCode: itemCode,
                        unlikeStatus: unlikeStatus,
                        imageUrl: imageUrl,
                        itemName: itemName,
                        itemPrice: itemPrice,
                        itemUrl: itemUrl,
                        genreName: genreName,
                    }),
                })
                .then((data) => {
                    // レスポンスを処理
                    console.log(data);
                    itemBox.remove(); // item-box-mainを削除
                })
                .then((response) => response.json())
                .catch((error) => {
                    console.error("エラー:", error);
                });
            return false;
        });
    });
</script>



@endsection