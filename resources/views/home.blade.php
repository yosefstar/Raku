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
                @endif
                @foreach($items as $item)
                    <div>
                        <img src="{{ $item->imageUrl }}" alt="商品画像">
                        <p>商品名: {{ $item->itemName }}</p>
                        <p>価格: {{ $item->itemPrice }}</p>
                        <a href="{{ $item->itemUrl }}">商品ページへ</a>
                        <form action="{{ route('wantItem') }}" method="POST">
                            @csrf
                            <input type="hidden" name="imageUrl" value="{{ $item->imageUrl }}">
                            <input type="hidden" name="itemName" value="{{ $item->itemName }}">
                            <input type="hidden" name="itemPrice" value="{{ $item->itemPrice }}">
                            <input type="hidden" name="itemUrl" value="{{ $item->itemUrl }}">
                            <input type="hidden" name="itemCode" value="{{ $item->itemCode }}">
                            <button type="submit">Want</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
