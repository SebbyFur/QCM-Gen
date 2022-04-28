@extends('layout.app')

@section('title')
    Ajout
@endsection

@section('content')
<div class="container">
    <h1 class="text-center my-5">Ajouter une question</h1>
    <div class="container">
        <div class="container">
        <div class="input-group mb-3">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Tags</button>
            <ul class="dropdown-menu">
                <?php
                    foreach (App\Models\Tags::all() as $a) echo
                    "<div class='mx-3 my-2'>
                        <input class='form-check-input checkboxes' type='checkbox' value='$a[id]' id='flexCheckDefault'>
                        <label class='form-check-label' for='flexCheckDefault'>
                            $a[tag]
                        </label>
                    </div>"
                ?>
            </ul>
            <input type="text" class="form-control mx-2 question-input" id="questions-dropdown" data-bs-toggle="dropdown">
            <div class="dropdown-menu questions-div" aria-labelledby="questions-dropdown"></div>
            <button type='button'class='btn btn-primary ml-2 rmv-btn'><i class="bi bi-dash-circle-fill"></i></button>
        </div>
    </div>
    <div class="container holder"></div>
    <div class="row">
        <div class="col-md-12 text-center">
            <button type='button' class='add-entry btn btn-success w-25'><i class="bi bi-plus-circle-fill icon-add"></i></button>
        </div>
    </div>
</div>

<script src="{{ asset('js/scripts/add_qanda.js') }}"></script>
@endsection

<script type="text/javascript">
    ADDQUESTIONROUTE = "{{ route('addquestion') }}";
    FUZZYSEARCHQUESTIONROUTE = "{{ route('fuzzysearchquestion') }}";
</script>