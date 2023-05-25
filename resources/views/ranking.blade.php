@extends('layouts.app')


@section('content')

<div class="container">
    <h1>ランキング</h1>
    <ol>
        @foreach($ranking as $item)
            @php
                $itemData = App\Models\Item::where('itemCode', $item->itemCode)->first();
            @endphp
            <li>
                <img src="{{ $itemData->imageUrl }}" alt="商品画像">
                <p>want数: {{ $item->total }}</p>

                @if($itemData)
                    <ul>
                        <li>商品名: {{ $itemData->itemName }}</li>
                        <li>価格: {{ $itemData->itemPrice }}</li>
                        <li><a href="{{ $itemData->itemUrl }}">商品ページへ</a></li>
                    </ul>
                @endif
            </li>
        @endforeach
    </ol>
</div>

@endsection
