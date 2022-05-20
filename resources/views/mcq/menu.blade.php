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
            <div class="model-mcqs border border-3 rounded my-2" style="height: 50vh">
                
            </div>
        </div>
        <div class="my-5">
            <div class="d-flex">
                <h2 class="flex-grow-1">QCMs basés sur une catégorie</h2>
                <a type="button" class="btn btn-success" href="{{ route('mcqcreate') }}">Créer un QCM basé sur une catégorie</a>
            </div>
            <div class="category-mcqs border border-3 rounded my-2" style="height: 50vh">
                
            </div>
        </div>
        <div class="my-5">
            <div class="d-flex">
                <h2 class="flex-grow-1">QCMs non classés</h2>
                <a type="button" class="btn btn-success" href="{{ route('mcqcreate') }}">Créer un QCM</a>
            </div>
            <div class="unclassed-mcqs border border-3 rounded my-2" style="height: 50vh">

            </div>
        </div>
    </div>
</div>

@routes

@endsection