@extends('layout.app')

@section('title')
    Groupes et étudiants
@endsection

@section('content')

<div>
    <h1 class="text-center my-5"><strong>Gestion des groupes et étudiants</strong></h1>
    <div class="row">
        <div class="col">
            <div class="mx-4 border border-1" style='background-color: #f9f9f9;'>
                <div class="groups scroll-margin my-2" style='height: 35rem; overflow-y: scroll;'>
                    <div>
                        @foreach ($groups as $group)
                        <div class="container d-flex mb-2">
                            <div class="d-flex list-group-item flex-grow-1">
                                <div>#{{ $group->id }}.</div>
                                <div class='mx-1'>
                                    <div data-id='{{ $group->id }}' class='group-item'>{{ $group->name_group }}</div>
                                </div>
                            </div>
                            <button data-id='{{ $group->id }}' type='button' class='btn btn-primary mx-1 group-info'><i class="bi bi-list"></i></button>
                            <div class='dropdown dropend'>
                                <button type='button' id="dropdownMenuLink" data-bs-toggle="dropdown" class='h-100 btn btn-danger'><i class="bi bi-dash-circle-fill"></i></button>
                                <div class='dropdown-menu px-3' aria-labelledby="dropdownMenuLink">
                                    <p class='text-center'>Vous êtes sur le point de supprimer ce groupe. Les informations relatives aux étudiants seront conservées. Êtes-vous sûr ?</p>
                                    <button data-id='{{ $group->id }}' type='button' class='btn btn-primary mx-1 rm-group'>Oui</button>
                                    <button type='button' class='btn btn-danger mx-1'>Non</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="container d-flex mb-2">
                        <div class="d-flex list-group-item flex-grow-1">
                            <div class='mx-1'>
                                <div data-id='NONE' class='group-item'>Autre</div>
                            </div>
                        </div>
                        <button data-id='NONE' type='button' class='btn btn-primary ms-1 group-info'><i class="bi bi-list"></i></button>
                    </div>
                </div>
                <div class="d-flex justify-content-center my-2">
                    <input type="text" class="form-control me-2 w-50 group-input" placeholder="Entrez un nom de groupe...">
                    <button type='button' class='add-group btn btn-success'><i class="bi bi-plus-circle-fill icon-add"></i></button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="mx-4 border border-1" style='background-color: #f9f9f9;'>
                <div class="students scroll-margin my-2" style='height: 35rem; overflow-y: scroll;'></div>
                <div class="d-flex justify-content-center my-2 dropup">
                    <button type='button' id="dropdownMenuLink" data-bs-toggle="dropdown" class='btn btn-success w-50 add-student-button-dropdown' disabled><i class="bi bi-plus-circle-fill icon-add"></i></button>
                    <div class='dropdown-menu px-3 text-center' aria-labelledby="dropdownMenuLink">
                        <input type="text" class="form-control create-student-first-name-input" placeholder="Entrez un nom...">
                        <input type="text" class="form-control my-2 create-student-last-name-input" placeholder="Entrez un prénom...">
                        <button type='button' class='btn btn-primary mx-1 w-50 add-student-button'><i class="bi bi-plus-circle-fill icon-add"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="mx-4 border border-1" style='background-color: #f9f9f9;'>
                <div class="student scroll-margin my-2 d-flex flex-column justify-content-center align-items-center" style='height: 35rem; overflow-y: scroll;'>
                    <input type="text" class="edit-student-first-name-input form-control my-5 w-50" placeholder="Entrez un nom..." hidden>
                    <input type="text" class="edit-student-last-name-input form-control my-5 w-50" placeholder="Entrez un prénom..." hidden>
                </div>
                <div class="d-flex justify-content-center my-2">
                    <button type='button' class='change-group-button btn btn-primary w-50' disabled>Changer le groupe</button>
                </div>
            </div>
        </div>
    </div>
</div>

@routes
<script src="{{ asset('js/scripts/group_menu.js') }}"></script>

@endsection