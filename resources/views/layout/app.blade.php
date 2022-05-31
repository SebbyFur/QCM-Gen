<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>QCM - @yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('metas')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/scripts/search_bar.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body style='min-height: 100%'>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('welcome') }}">QAT Maker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="nav-link" href="{{ route('mcqmenu') }}">QCMs</a>
                    <a class="nav-link" href="{{ route('modelmenu') }}">Modèles</a>
                    <a class="nav-link" href="{{ route('qatmenu') }}">Questions</a>
                    <a class="nav-link" href="{{ route('groupsmenu') }}">Groupes et étudiants</a>
                    <a class="nav-link" href="{{ route('exammenu') }}">Examens</a>
                </ul>
                <div class="dropdown d-flex flex-grow-1">
                    <input type="text" class="form-control question-input-nav py-2 mx-2" placeholder="Rechercher une question..." data-bs-toggle="dropdown">
                    <ul class="dropdown-menu search-data-nav" aria-labelledby="dLabel"></ul>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <div class="fixed-bottom d-flex justify-content-center w-100 alert" style='pointer-events: none'></div>
</body>
</html>

<script>new SearchBar(document.querySelector('.question-input-nav'), document.querySelector('.search-data-nav'))</script>