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
                <button type='button' class='btn btn-danger mx-2'><i class="bi bi-dash-circle-fill"></i></button>
            </div>
        @endforeach
    </div>
</div>

<script>
    const UPDATE_GROUP_ROUTE = "{{ route('updategroup') }}";
</script>

<script src="{{ asset('js/scripts/group_menu.js') }}"></script>

@endsection