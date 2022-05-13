@extends('layout.app')

@section('title')
    Edition
@endsection

@section('content')

<div class="container">
    <h1 class="text-center my-5"><strong>Edition du QCM #{{ $mcq['id'] }} : {{ $mcq['title'] }}</strong></h1>
</div>

@routes
<script src="{{ asset('js/scripts/qat_edit.js') }}"></script>

@endsection