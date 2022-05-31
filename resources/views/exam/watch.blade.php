@extends('layout.app')

@section('title')
    Examens
@endsection

@section('content')

<div class="container">
    <h1 class="py-5 text-center"><strong>Consultation des QCMs de l'examen #{{ $id }}</strong></h1>
    @if (count($data) != 0)
    <div class="row">
        @foreach ($data as $mcq)
        <div class="col-sm-3 model-div-{{$mcq->id}}">
            <div class="card mx-auto my-4" style="width: 12rem">
                <div class="card-body d-flex align-items-center flex-column text-break">
                    <h5 class="card-title text-center">{{$mcq->title}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">#{{$mcq->id}}</h6>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a class="btn btn-success" href="{{ route('correctionwatch', $mcq->id) }}">Corriger le QCM</a>
                        <a class="btn btn-primary my-2" href="{{ route('mcqpdf', $mcq->id) }}">Obtenir le PDF</a>
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
    </div>
    @else
        <div class="text-center">
            <h1>Rien à voir ici... Pour le moment !</h1>
            <div class="d-flex justify-content-center align-items-center my-5">
                <a class="btn btn-success px-3 py-3" href="{{ route('mcqmenu') }}">
                    <h2>Ajouter des QCMs à l'examen</h2>
                </a>
                <h3 class="mx-5">... ou ...</h3>
                <a class="btn btn-primary px-3 py-3" href="{{ route('mcqcreate') }}">
                    <h2>Créer des QCMs pour l'examen</h2>
                </a>
            </div>
        </div>
    @endif
</div>

@routes
<script src="{{ asset('js/scripts/exam_watch.js') }}"></script>

@endsection