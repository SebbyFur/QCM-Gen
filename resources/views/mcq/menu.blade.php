@extends('layout.app')

@section('title')
    QCMs
@endsection

@section('content')

<div class="container">
    <h1 class="py-5 text-center"><strong>Gestion de QCMs</strong></h1>
    <div>
        <div class="my-5">
            <div class="d-flex">
                <h2 class="flex-grow-1">QCMs basés sur un modèle</h2>
                <a type="button" class="btn btn-success" href="{{ route('mcqcreate') }}">Créer un QCM basé sur un modèle</a>
            </div>
            <div class="model-mcqs rounded my-2">
                <div class="row">
                    @if (count($data['mcqmodel']) == 0)
                        <h2 class="text-center text-secondary">(vide)</h2>
                    @else
                        @foreach ($data['mcqmodel'] as $mcq)
                        <div class="col-sm-3 model-div-{{$mcq->id}}">
                            <div class="card mx-auto my-4" style="width: 12rem; height: 14rem;">
                                <div class="card-body d-flex align-items-center flex-column text-break">
                                    <h5 class="card-title text-center">{{$mcq->title}}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">#{{$mcq->id}}</h6>
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <a class="btn btn-success">Consulter le QCM</a>
                                        <a class="btn btn-primary my-2 edit-mcq">Obtenir le PDF</a>
                                        <div class='dropdown dropup'>
                                            <button type='button' id="dropdownMenuLink" data-bs-toggle="dropdown" class='btn btn-danger'>Détruire le QCM</button>
                                            <div class='dropdown-menu px-3' aria-labelledby="dropdownMenuLink">
                                                <p class='text-center'>Vous êtes sur le point de supprimer ce QCM. Vous ne pourrez plus le corriger par la suite. Êtes-vous sûr ?</p>
                                                <button data-id='{{ $mcq['id'] }}' type='button' class='btn btn-primary mx-1 delete-mcq-button'>Oui</button>
                                                <button type='button' class='btn btn-danger mx-1'>Non</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="my-5">
            <div class="d-flex">
                <h2 class="flex-grow-1">QCMs basés sur une catégorie</h2>
                <a type="button" class="btn btn-success" href="{{ route('mcqcreate') }}">Créer un QCM basé sur une catégorie</a>
            </div>
            <div class="category-mcqs rounded my-2">
                <div class="row">
                    @if (count($data['mcqtag']) == 0)
                        <h2 class="text-center text-secondary">(vide)</h2>
                    @else
                        @foreach ($data['mcqtag'] as $mcq)
                        <div class="col-sm-3 model-div-{{$mcq->id}}">
                            <div class="card mx-auto my-4" style="width: 12rem; height: 14rem;">
                                <div class="card-body d-flex align-items-center flex-column text-break">
                                    <h5 class="card-title text-center">{{$mcq->title}}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">#{{$mcq->id}}</h6>
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <a class="btn btn-success">Consulter le QCM</a>
                                        <a class="btn btn-primary my-2 edit-mcq">Obtenir le PDF</a>
                                        <div class='dropdown dropup'>
                                            <button type='button' id="dropdownMenuLink" data-bs-toggle="dropdown" class='btn btn-danger'>Détruire le QCM</button>
                                            <div class='dropdown-menu px-3' aria-labelledby="dropdownMenuLink">
                                                <p class='text-center'>Vous êtes sur le point de supprimer ce QCM. Vous ne pourrez plus le corriger par la suite. Êtes-vous sûr ?</p>
                                                <button data-id='{{ $mcq['id'] }}' type='button' class='btn btn-primary mx-1 delete-mcq-button'>Oui</button>
                                                <button type='button' class='btn btn-danger mx-1'>Non</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="my-5">
            <div class="d-flex">
                <h2 class="flex-grow-1">QCMs non classés</h2>
                <a type="button" class="btn btn-success" href="{{ route('mcqcreate') }}">Créer un QCM</a>
            </div>
            <div class="unclassed-mcqs rounded my-2">
                <div class="row">
                    @if (count($data['mcqunclassed']) == 0)
                        <h2 class="text-center text-secondary">(vide)</h2>
                    @else
                        @foreach ($data['mcqunclassed'] as $mcq)
                        <div class="col-sm-3 model-div-{{$mcq->id}}">
                            <div class="card mx-auto my-4" style="width: 12rem; height: 14rem;">
                                <div class="card-body d-flex align-items-center flex-column text-break">
                                    <h5 class="card-title text-center">{{$mcq->title}}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">#{{$mcq->id}}</h6>
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <a class="btn btn-success">Consulter le QCM</a>
                                        <a class="btn btn-primary my-2 edit-mcq">Obtenir le PDF</a>
                                        <div class='dropdown dropup'>
                                            <button type='button' id="dropdownMenuLink" data-bs-toggle="dropdown" class='btn btn-danger'>Détruire le QCM</button>
                                            <div class='dropdown-menu px-3' aria-labelledby="dropdownMenuLink">
                                                <p class='text-center'>Vous êtes sur le point de supprimer ce QCM. Vous ne pourrez plus le corriger par la suite. Êtes-vous sûr ?</p>
                                                <button data-id='{{ $mcq['id'] }}' type='button' class='btn btn-primary mx-1 delete-mcq-button'>Oui</button>
                                                <button type='button' class='btn btn-danger mx-1'>Non</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@routes
<script src="{{ asset('js/scripts/mcq_menu.js') }}"></script>

@endsection