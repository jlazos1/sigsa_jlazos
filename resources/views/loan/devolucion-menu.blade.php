@extends('layouts.prestamo')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h3>Devolución de préstamos</h3>
                <p>Seleccione el tipo de préstamo</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 offset-md-3">
                <div class="card text-center">
                    <img src="{{ asset('icons/001-profesor-1.png') }}" class="card-img-top p-5">
                    <div class="card-body">
                        <h5 class="card-title">Funcionarios</h5>
                        <p class="card-text">
                            Devolución de préstamos de funcionarios
                        </p>
                        <a href="{{ route('devolucion.funcionario') }}" class="btn btn-primary">Ingresar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <img src="{{ asset('icons/005-estudiantes.png') }}" class="card-img-top p-5">
                    <div class="card-body">
                        <h5 class="card-title">Estudiantes</h5>
                        <p class="card-text">
                            Devolución de préstamos de estudiantes
                        </p>
                        <a href="{{ route('devolucion.estudiante') }}" class="btn btn-success">
                            Ingresar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
