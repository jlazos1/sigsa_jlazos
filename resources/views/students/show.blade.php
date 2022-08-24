@extends('layouts.asistencia')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Asistencia por alumno</h1>
            <h2>{{$estudiante->name}}</h2>
        </div>
    </div>
</div>
@endsection
