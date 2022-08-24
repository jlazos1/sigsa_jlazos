@extends('layouts.prestamo')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col text-center mb-3 mt-3">
                <h1>Sistema de préstamos </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3 text-center">
                    <div class="card-body">
                        <img class="img-fluid mb-3" src="{{ asset('icons/002-profesor-2.png') }}" alt="">
                        <h5 class="card-title">Préstamo a <br>Funcionarios(as)</h5>
                        <a href="{{ route('prestamo.create_funcionario') }}" class="btn btn-outline-light form-control">
                            Ingresar
                        </a>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3 text-center">
                    <div class="card-body">
                        <img class="img-fluid mb-3" src="{{ asset('icons/003-estudiante-1.png') }}" alt="">
                        <h5 class="card-title">Préstamo a <br>Estudiantes</h5>
                        <a href="{{ route('prestamo.create_estudiante') }}" class="btn btn-outline-light form-control">
                            Ingresar
                        </a>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3 text-center">
                    <div class="card-body">
                        <img class="img-fluid mb-3" src="{{ asset('icons/001-entregar.png') }}" alt="">
                        <h5 class="card-title">Devolución de <br>Préstamos</h5>
                        <a href="{{ route('devolucion.menu') }}" class="btn btn-outline-light form-control">
                            Ingresar
                        </a>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 text-center">
                    <div class="card-body">
                        <img class="img-fluid mb-3" src="{{ asset('icons/004-lista-de-verificacin.png') }}" alt="">
                        <h5 class="card-title">Lista general <br>de Préstamos</h5>
                        <a href="{{ route('prestamo.lista') }}" class="btn btn-outline-light form-control">
                            Ingresar
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
