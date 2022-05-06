@extends('layout.app')

@section('title')
    Groupes
@endsection

@section('content')

<div class="container">
    <h1 class="py-5 text-center"><strong>Groupes de classe</strong></h1>
    <div class='container list-group'>
        @foreach($ret as $group)
            <div class="container d-flex mb-2">
                <div class="d-flex list-group-item w-100">
                    <div>#{{ $group->id }}.</div>
                    <div id='{{ $group->id }}' class='mx-1'>
                        <div class='group-item'>{{ $group->name_group }}</div>
                    </div>
                </div>
                <div class='dropdown dropend px-2'>
                    <button type='button' id="dropdownMenuLink" data-bs-toggle="dropdown" class='h-100 btn btn-danger rm-question'><i class="bi bi-dash-circle-fill"></i></button>
                    <div class='dropdown-menu px-3' aria-labelledby="dropdownMenuLink">
                        <p class='text-center'>Vous êtes sur le point de supprimer ce groupe. Les informations relatives aux étudiants seront conservées. Êtes-vous sûr ?</p>
                        <button id='{{ $group['id'] }}' type='button' class='btn btn-primary mx-1 rm-group'>Oui</button>
                        <button type='button' class='btn btn-danger mx-1'>Non</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        <input type="text" class="form-control me-2 w-25" placeholder="Entrez un nom de groupe à créer...">
        <button type='button' class='add-group btn btn-success'><i class="bi bi-plus-circle-fill icon-add"></i></button>
    </div>
</div>

<script>
    const UPDATE_GROUP_ROUTE = "{{ route('updategroup') }}";
    const DELETE_GROUP_ROUTE = "{{ route('deletegroup') }}";
    const CREATE_GROUP_ROUTE = "{{ route('creategroup') }}";
</script>

<script src="{{ asset('js/scripts/group_menu.js') }}"></script>

@endsection