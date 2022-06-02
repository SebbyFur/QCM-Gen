@extends('layout.app')

@section('title')
    Etudiants
@endsection

@section('content')

<div class="container">
    <h1 class='text-center my-5'>Bienvenue!</h1>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="d-flex justify-content-center align-items-center mt-5">
            <a class="btn btn-outline-success mx-3 py-3" href="{{ route('mcqmenu') }}">
                <h2>Consulter les QCMs</h2>
            </a>
            <a class="btn btn-outline-success mx-3 py-3" href="{{ route('mcqcreate') }}">
                <h2>Créer un QCM</h2>
            </a>
        </div>
        <h3 class="my-5">... ou ...</h3>
        <div class="d-flex justify-content-center align-items-center">
            <a class="btn btn-outline-primary mx-3 py-3" href="{{ route('exammenu') }}">
                <h2>Créer un examen</h2>
            </a>
            <a class="btn btn-outline-primary mx-3 py-3" href="{{ route('groupsmenu') }}">
                <h2>Gérer les groupes et étudiants</h2>
            </a>
            <a class="btn btn-outline-primary mx-3 py-3" href="{{ route('modelmenu') }}">
                <h2>Créer un modèle</h2>
            </a>
        </div>
        <h3 class="my-5">... ou ...</h3>
        <div class="d-flex justify-content-center align-items-center mt-5">
            <a class="btn btn-outline-success mx-3 py-3" href="{{ route('qatmenu') }}">
                <h2>Créer une question</h2>
            </a>
        </div>
    </div>
</div>

@routes
<script src="{{ asset('js/scripts/group_menu.js') }}"></script>

@endsection