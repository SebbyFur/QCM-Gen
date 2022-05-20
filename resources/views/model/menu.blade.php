@extends('layout.app')

@section('title')
    Modèles
@endsection

@section('content')

<div class="container">
    <h1 class="py-5 text-center"><strong>Création et modification de modèles</strong></h1>
    <div class="row">
        @foreach ($models as $model)
        <div class="col-sm-3 model-div-{{$model->id}}">
            <div class="card mx-auto my-4" style="width: 12rem; height: 14rem;">
                <div class="card-body d-flex align-items-center flex-column text-break">
                    <h5 class="card-title text-center">{{$model->title}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">#{{$model->id}}</h6>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a class="btn btn-success">Générer un QCM</a>
                        <a class="btn btn-primary my-2 edit-model" href='{{ route('editmodel', $model['id']) }}'>Modifier le modèle</a>
                        <div class='dropdown dropup'>
                            <button type='button' id="dropdownMenuLink" data-bs-toggle="dropdown" class='btn btn-danger'>Détruire le modèle</button>
                            <div class='dropdown-menu px-3' aria-labelledby="dropdownMenuLink">
                                <p class='text-center'>Vous êtes sur le point de supprimer ce modèle. Tous les QCMs générés à partir de cette base seront conservés. Voulez-vous continuer ?</p>
                                <button data-id='{{ $model['id'] }}' type='button' class='btn btn-primary mx-1 delete-model-button'>Oui</button>
                                <button type='button' class='btn btn-danger mx-1'>Non</button>
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
                    <input type="text" class="form-control create-model-title-input" placeholder="Entrez un titre...">
                    <button type='button' class='btn btn-success create-model-button my-2'><i class="bi bi-plus-circle-fill icon-add"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

@routes
<script src="{{ asset('js/scripts/model_menu.js') }}"></script>

@endsection