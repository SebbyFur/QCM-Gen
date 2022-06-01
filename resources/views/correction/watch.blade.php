@extends('layout.app')

@section('title')
    Consulation
@endsection

@section('content')

<div class="container">
    <h1 class="py-5 text-center"><strong>Consulation du QCM #{{ $data['id'] }} : {{ $data['title'] }}</strong></h1>
    <h2 class="py-2 text-center mark">{{ $data['mark'] }}% de réussite</h2>
    @foreach ($data['questions'] as $question)
    <ul class="list-group my-5">
        <li class="list-group-item"><strong>#{{ $question->id }}. {{ $question->question }}</strong></li>
        @foreach ($question->answers as $answer)
        <div class="d-flex align-items-center">
            <input type='checkbox' data-id={{$answer->id_mcq_data}} class="form-check-input checkbox me-2" @if ($answer->checked) checked @endif/>
            <li class="list-group-item flex-grow-1" @if ($answer->is_correct == 1) style='background-color: #7ac079' @endif>{{ $answer->choice }}. {{ $answer->answer }}</li>
        </div>
        @endforeach
    </ul>
    @endforeach
</div>

@routes
<script src="{{ asset('js/scripts/correction.js') }}"></script>

@endsection