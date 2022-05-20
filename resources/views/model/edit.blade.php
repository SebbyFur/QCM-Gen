@extends('layout.app')

@section('title')
    Edition
@endsection

@section('metas')
<meta name='id' id={{ $model['id'] }}>
@endsection

@section('content')

<div class="container">
    <h1 class="text-center my-5"><strong>Edition du modèle #{{ $model['id'] }} : {{ $model['title'] }}</strong></h1>
    <div class="row">
        <div class="col-6">
            <div class="mx-4 border border-1" style='background-color: #f9f9f9;'>
                <h2 class="text-center my-2">Questions du modèle</h2>
                <div class="questions-data-div scroll-margin my-3" style='height: 35rem; overflow-y: scroll;'>
                    @foreach ($data as $qdata)
                    <div class="container question-data-div-{{ $qdata['id'] }} d-flex mb-2">
                        <div class="d-flex list-group-item w-100" @if($qdata['is_valid'] == 0)style='background-color: #f6df6d'@endif data-id="{{ $qdata['id'] }}">
                            <div>#{{ $qdata['id_question'] }}.</div>
                            <div class="mx-1">
                                <div class="group-item d-flex">{{ $qdata['question'] }}</div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger delete-question-button mx-1" data-id="{{ $qdata['id'] }}"><i class="bi bi-dash-circle-fill"></i></button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="mx-4 border border-1" style='background-color: #f9f9f9;'>
                <h2 class="text-center my-2">Questions</h2>
                <div class="dropdown d-flex flex-grow-1 mx-3">
                    <input type="text" class="form-control question-input py-2 mx-2" placeholder="Rechercher une question..." data-bs-toggle="dropdown">
                    <ul class="dropdown-menu search-data" aria-labelledby="dLabel"></ul>
                </div>
                <div class="questions-div scroll-margin my-3" style='height: 35rem; overflow-y: scroll;'></div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn previous-questions" disabled><i class="bi bi-arrow-left"></i></button>
                    <button type="button" class="btn next-questions"><i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

@routes
<script src="{{ asset('js/scripts/model_edit.js') }}"></script>

@endsection