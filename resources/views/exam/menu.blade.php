@extends('layout.app')

@section('title')
    Examens
@endsection

@section('content')

<div class="container">
    <h1 class="py-5 text-center"><strong>Création et modification d'examens</strong></h1>
    <div class="row">
        @foreach ($data as $exam)
        <div class="col-sm-3 exam-div-{{$exam->id}}">
            <div class="card mx-auto my-4" style="width: 12rem; height: 14rem;">
                <div class="card-body d-flex align-items-center flex-column text-break">
                    <h5 class="card-title text-center">{{$exam->title}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">#{{$exam->id}}</h6>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a class="btn btn-success my-4" href="{{ route('examview', $exam['id']) }}">Consulter les QCMs</a>
                        <div class='dropdown dropup'>
                            <button type='button' id="dropdownMenuLink" data-bs-toggle="dropdown" class='btn btn-danger'>Détruire l'examen</button>
                            <div class='dropdown-menu px-3' aria-labelledby="dropdownMenuLink">
                                <div class="d-flex justify-content-center flex-column">
                                    <p class='text-center'>Vous pouvez supprimer l'examen ainsi que tous ses QCMs, ou supprimer l'examen seulement.</p>
                                    <button data-id='{{ $exam['id'] }}' type='button' class='btn btn-warning mx-1 delete-mcq-exam-button'>Supprimer tout</button>
                                    <button data-id='{{ $exam['id'] }}' type='button' class='btn btn-primary mx-1 delete-exam-button my-2'>Supprimer</button>
                                    <button type='button' class='btn btn-danger mx-1'>Annuler</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-sm-3">
            <div class="dropdown dropend mx-auto d-flex justify-content-center align-items-center" style="width: 16rem; height: 16rem;">
                <button type='button' id="dropdownMenuLink" data-bs-toggle="dropdown" class='btn btn-success w-25 h-25'><i class="bi bi-plus-circle-fill icon-add"></i></button>
                <div class='dropdown-menu text-center px-3' aria-labelledby="dropdownMenuLink">
                    <input type="text" class="form-control create-exam-title-input" placeholder="Entrez un titre...">
                    <button type='button' class='btn btn-success create-exam-button my-2'><i class="bi bi-plus-circle-fill icon-add"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

@routes
<script src="{{ asset('js/scripts/exam_menu.js') }}"></script>

@endsection