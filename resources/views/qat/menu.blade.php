@extends('layout.app')

@section('title')
    Questions
@endsection

@section('content')

<div class="container">
    <h1 class="py-5 text-center"><strong>Création et modification de questions</strong></h1>
    <div class='container pt-2 pb-3 flex-grow-1 d-flex'>
        <div class="dropdown d-flex flex-grow-1">
            <input type="text" class="form-control question-input py-2 mx-2" placeholder="Rechercher une question..." data-bs-toggle="dropdown">
            <ul class="dropdown-menu search-data" aria-labelledby="dLabel"></ul>
        </div>
        <button type='button' class='btn btn-success add-question'><i class="bi bi-plus-circle-fill icon-add"></i></button>
    </div>
    <div class="container">
        @foreach ($ret as $a)
        <div class='container flex-grow-1 d-flex my-2'>
            <a href='{{ route('editquestion', $a['id']) }}' class="list-group-item list-group-item-action mx-2" @if($a['is_valid'] == 0)style='background-color: #f6df6d'@endif>#{{ $a['id'] }}. {{ $a['question'] }}</a>
            <div class='dropdown dropend'>
                <button type='button' id="dropdownMenuLink" data-bs-toggle="dropdown" class='h-100 btn btn-danger'><i class="bi bi-dash-circle-fill"></i></button>
                <div class='dropdown-menu px-3' aria-labelledby="dropdownMenuLink">
                    <p class='text-center'>Vous êtes sur le point de supprimer cette question et toutes ses réponses. Êtes-vous sûr ?</p>
                    <button id='{{ $a['id'] }}' type='button' class='btn btn-primary mx-1 rm-question'>Oui</button>
                    <button type='button' class='btn btn-danger mx-1'>Non</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $ret->links() }}
</div>

<style>
    .w-5 {
        display: none;
    }
</style>

@routes
<script src="{{ asset('js/scripts/qat_menu.js') }}"></script>

@endsection