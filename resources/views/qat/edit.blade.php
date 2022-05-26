@extends('layout.app')

@section('title')
    Edition
@endsection

@section('metas')
<meta name='id' id={{ $ret['question']['id'] }}>
@endsection

@section('content')
<div class="container">
    <h1 class="text-center my-5"><strong>Edition de la question #{{ $ret['question']['id'] }}</strong></h1>
    <div class="container">
        <div class="container">
            <div class="input-group mb-3">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Tags</button>
                <ul class="dropdown-menu">
                    @foreach(App\Models\Tags::all() as $a)
                        <div class='mx-3 my-2'>
                            <input class='form-check-input checkboxes' type='checkbox' id='{{ $a['id'] }}'>
                            <label class='form-check-label' for='flexCheckDefault'>
                                {{ $a['tag'] }}
                            </label>
                        </div>
                        @foreach($ret['tags'] as $key => $value)
                            @if ($value['id_tag'] == $a['id'])
                                <script>Array.from(document.getElementsByClassName('checkboxes')).at(-1).checked = true</script>
                            @endif
                        @endforeach
                    @endforeach
                </ul>
                <input type="text" class="form-control mx-2 question-input" value='{{ $ret['question']['question'] }}' placeholder="Entrez une question...">
                <div class='dropdown dropend'>
                    <button type='button' id="dropdownMenuLink" data-bs-toggle="dropdown" class='btn btn-primary ml-2 rmv-btn'><i class="bi bi-dash-circle-fill"></i></button>
                    <div class='dropdown-menu px-3' aria-labelledby="dropdownMenuLink">
                        <p class='text-center'>Vous êtes sur le point de supprimer cette question et toutes ses réponses. Êtes-vous sûr ?</p>
                        <button type='button' class='btn btn-primary mx-1 rm-question'>Oui</button>
                        <button type='button' class='btn btn-danger mx-1'>Non</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container answers-div">
            @foreach ($ret['answers'] as $array)
            <div class='mb-4'>
                <div class='flex-grow-1 d-flex answer-div' id='{{ $array['id'] }}''>
                    @if ($array['is_correct'] == 0)
                        <input class='form-check-input mx-2 my-3 is_correct' type='checkbox'>
                    @else
                        <input class='form-check-input mx-2 my-3 is_correct' type='checkbox' checked>
                    @endif
                    <input class='form-control mx-2 answer' type='text' value='{{ $array['answer'] }}' placeholder="Entrez une réponse...">
                    <button type='button' class='btn btn-danger ml-2 rm-answer'><i class="bi bi-dash-circle-fill"></i></button>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <button type='button' class='add-entry btn btn-success w-25'><i class="bi bi-plus-circle-fill icon-add"></i></button>
        </div>
    </div>
    <div class="d-flex justify-content-center my-3">
        <div class="form-floating w-50">
            <select class="form-select number-questions-select" id="questions">
                @for ($i = $ret['minPossibleAnswers']; $i <= 6; $i++)
                <option class="select-answers-max" value="{{ $i }}" @if ($i == $ret['question']['answer_count']) selected @endif>{{ $i }}</option>
                @endfor
            </select>
            <label for="questions" class='mx-2'>Sélectionnez le nombre de réponses possible pour cette question</label>
        </div>
    </div>
</div>

@routes
<script src="{{ asset('js/scripts/qat_edit.js') }}"></script>

@endsection