@extends('layouts.app')

@section('content')
<h1 class="custom-h1">ランキング</h1>
<div class="ranking-container">

    <div class="ranking-want-have">

        <div class="ranking-want">
            <p class="custom-p">お気に入りランキング</p>
            @foreach($wantRankings as $item)
            @php
            $itemData = App\Models\Want::where('itemCode', $item->itemCode)->first();
            @endphp

            <div class="item-box">
                <img src="{{ $itemData->imageUrl }}" alt="商品画像" class="item-image">
                <div class="item-box-main">

                    @if($itemData)
                    <div class="item-box-main">
                        <p>お気に入り数: {{ $item->total }}</p>


                        <a href="{{ $itemData->itemUrl }}">
                            <p>商品名: {{ $itemData->itemName }}</p>
                        </a>
                        <p>価格: {{ number_format($itemData->itemPrice) }}円</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="ranking-have">
            <p class="custom-p">持っているランキング</p>
            @foreach($haveRankings as $item)
            @php
            $itemData = App\Models\Have::where('itemCode', $item->itemCode)->first();
            @endphp

            <div class="item-box">
                <img src="{{ $itemData->imageUrl }}" alt="商品画像" class="item-image">
                <div class="item-box-main">

                    @if($itemData)
                    <div class="item-box-main">
                        <p>持っている数: {{ $item->total }}</p>
                        <a href="{{ $item->itemUrl }}">
                            <p>商品名: {{ $itemData->itemName }}</p>
                        </a>
                        <p>価格: {{ number_format($itemData->itemPrice) }}円</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection