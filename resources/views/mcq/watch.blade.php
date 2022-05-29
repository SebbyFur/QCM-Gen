@extends('layout.app')

@section('title')
    Consulation
@endsection

@section('content')

<div class="container">
    <h1 class="py-5 text-center"><strong>Consulation du QCM #{{ $data['id'] }} : {{ $data['title'] }}</strong></h1>
    @foreach ($data['questions'] as $question)
    <ul class="list-group my-5">
        <li class="list-group-item"><strong>#{{ $question->id }}. {{ $question->question }}</strong></li>
        @foreach ($question->answers as $answer)
        <li class="list-group-item" @if ($answer->is_correct == 1) style='background-color: #7ac079' @endif>{{ $answer->choice }}. {{ $answer->answer }}</li>
        @endforeach
    </ul>
    @endforeach
</div>

@routes

@endsection