@extends('layout.app')

@section('title')
    Edition
@endsection

@section('content')

<div class="container">
    <h1 class="text-center my-5"><strong>Edition du QCM #{{ $model['id'] }} : {{ $model['title'] }}</strong></h1>
</div>

@routes

@endsection