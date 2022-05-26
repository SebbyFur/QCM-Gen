@extends('layout.app')

@section('title')
    Génération
@endsection

@section('content')

<div class="container">
    <h1 class="py-5 text-center"><strong>Génération de QCMs</strong></h1>
    <h2 class='mt-3'>Type de QCM</h2>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-model-tab" data-bs-toggle="pill" data-bs-target="#pills-model" type="button" role="tab" aria-controls="pills-model" aria-selected="true">Génération de QCM par modèle</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-tag-tab" data-bs-toggle="pill" data-bs-target="#pills-tag" type="button" role="tab" aria-controls="pills-tag" aria-selected="false">Génération de QCM par tag</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-random-tab" data-bs-toggle="pill" data-bs-target="#pills-random" type="button" role="tab" aria-controls="pills-random" aria-selected="false">Génération de QCM aléatoire</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-model" role="tabpanel" aria-labelledby="pills-model-tab">
            <div class="row">
                @if ($data['models']->count() == 0)
                    <h2 class="text-center text-secondary my-5">(aucun modèle existant)</h2>
                @else
                    @foreach ($data['models'] as $model)
                    <div class="col-sm-3 model-div-{{$model->id}}">
                        <div class="card mx-auto my-4" style="width: 12rem; height: 14rem;">
                            <div class="card-body d-flex align-items-center flex-column text-break">
                                <h5 class="card-title text-center">{{$model->title}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">#{{$model->id}}</h6>
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <a class="btn btn-primary my-2 edit-model" href='{{ route('editmodel', $model['id']) }}'>Modifier le modèle</a>
                                    @if ($model['is_generator'] == 1)
                                    <input class="form-check-input model-radio-button" type="radio" name="exampleRadios" value="{{ $model->id }}" checked>
                                    @else
                                    <div class="text-center">Ce modèle n'est pas générateur. Certaines questions sont invalides ou il est vide!</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="tab-pane fade" id="pills-tag" role="tabpanel" aria-labelledby="pills-tag-tab">
            <div>
                @foreach ($data['tags'] as $tag)
                <div class="form-check my-2">
                    <input class="form-check-input tag-radio-button" type="radio" name="exampleRadios" id="exampleRadios1" value="{{ $tag['id'] }}" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        {{ $tag['tag'] }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="pills-random" role="tabpanel" aria-labelledby="pills-random-tab">
            Ac
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="form-floating w-50 mx-3">
            <select class="form-select questions-select" id="questionsSelect" disabled>

            </select>
            <label for="questionsSelect" class='mx-2'>Sélectionnez le nombre de questions pour le QCM</label>
        </div>
    </div>
    <h2 class='mt-5'>Choix des étudiants</h2>
    <div class="row">
        <div class="col">
            <div class="border border-1" style='background-color: #f9f9f9;'>
                <div class="groups scroll-margin my-2" style='height: 35rem; overflow-y: scroll;'>
                    @foreach ($data['groups'] as $group)
                    <div class="container d-flex mb-2">
                        <div class="d-flex list-group-item flex-grow-1">
                            <div>#{{ $group->id }}.</div>
                            <div class='mx-1'>
                                <div data-id='{{ $group->id }}' class='group-item'>{{ $group->name_group }}</div>
                            </div>
                        </div>
                        <button data-id='{{ $group->id }}' type='button' class='btn btn-outline-primary mx-1 group-info'><i class="bi bi-list"></i></button>
                    </div>
                    @endforeach
                    <div class="container d-flex mb-2">
                        <div class="d-flex list-group-item flex-grow-1">
                            <div class='mx-1'>
                                <div data-id='NONE' class='group-item'>Autre</div>
                            </div>
                        </div>
                        <button data-id='NONE' type='button' class='btn btn-outline-primary mx-1 group-info'><i class="bi bi-list"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="border border-1" style='background-color: #f9f9f9;'>
                <div class="students scroll-margin my-2" style='height: 35rem; overflow-y: scroll;'>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@routes
<script src="{{ asset('js/scripts/mcq_create.js') }}"></script>

@endsection