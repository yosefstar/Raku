@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
            @if (isset($errorMessage))
    <p>{{ $errorMessage }}</p>
@else
    @if (count($searchItems) > 0)
        <ul>
        @foreach ($searchItems as $items)
            @foreach ($items as $item)
                <li>{{ $item['Item']['itemName'] }}</li>
                @if (isset($item['Item']['mediumImageUrls'][0])) <!-- 最初の画像のみを表示 -->
                    <ul>
                        <li>
                            <img src="{{ $item['Item']['mediumImageUrls'][0]['imageUrl'] }}" alt="商品画像">
                            <form action="{{ route('saveItem') }}" method="POST">
                                @csrf
                                <input type="hidden" name="itemCode" value="{{ $item['Item']['itemCode'] }}">
                                <button type="submit">Want</button>
                            </form>
                        </li>
                    </ul>
                @endif
            @endforeach
        @endforeach

        </ul>
    @else
        <p>No items found.</p>
    @endif
@endif
        </div>
    </div>
</div>
@endsection
