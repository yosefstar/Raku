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



@endsection