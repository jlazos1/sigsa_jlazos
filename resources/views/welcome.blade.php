@auth

    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row mt-3 mb-3">
                <div class="col text-center mb-3 mt-3">
                    <img src="{{ asset('img/logo_sigsa.png') }}" class="img-responsive" width="300px;">
                </div>


            </div>
            <div class="row">
                <div class="col text-center">
                    {{-- @auth
                    <div class="row">
                        <div class="col">
                            <a class="btn btn-primary btn-block" href="/home">
                                Ir a la carga de archivos
                            </a>
                        </div>
                    </div>
                    @else --}}
                    <div class="row">
                        <div class="col">
                            <div class="row mt-3">

                                @if (session()->has('Asistencia'))
                                    <div class="col-md-3 text-center">
                                        <div class="card">
                                            <img src="{{ asset('img/asistencia.png') }}" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Asistencia</h5>
                                                <a class="btn btn-danger btn-block form-control" href="{{ route('home') }}">
                                                    Ingresar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                @if (session()->has('Canasta'))
                                    <div class="col-md-3 text-center">
                                        <div class="card">
                                            <img src="{{ asset('img/canasta.jpg') }}" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Canastas</h5>
                                                <a class="btn btn-primary btn-block form-control"
                                                    href="{{ route('canasta.carga') }}">
                                                    Ingresar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (session()->has('Inventario'))
                                    <div class="col-md-3 text-center">
                                        <div class="card">
                                            <img src="{{ asset('img/inventario.jpg') }}" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Inventario</h5>
                                                <a class="btn btn-success btn-block form-control"
                                                    href="{{ route('inventario.index') }}">
                                                    Ingresar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (session()->has('Préstamos'))
                                    <div class="col-md-3 text-center">
                                        <div class="card">
                                            <img src="{{ asset('img/prestamo.png') }}" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Préstamo</h5>
                                                <a class="btn btn-warning btn-block form-control"
                                                    href="{{ route('prestamo.index') }}">
                                                    Ingresar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (session()->has('Usuarios'))
                                    <div class="col-md-3 text-center">
                                        <div class="card">
                                            <img src="{{ asset('img/users.png') }}" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Usuarios</h5>
                                                <a class="btn btn-warning btn-block form-control"
                                                    href="{{ route('userIndex') }}">
                                                    Ingresar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (session()->has('Estudiantes'))
                                    <div class="col-md-3 text-center">
                                        <div class="card">
                                            <img src="{{ asset('img/users.png') }}" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Estudiantes</h5>
                                                <a class="btn btn-warning btn-block form-control"
                                                    href="{{ route('studentIndex') }}">
                                                    Ingresar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    {{-- @endauth --}}
                </div>
            </div>
        </div>
    @endsection

@endauth

@guest

    <div class="col text-center mb-3 mt-5">
        <img src="{{ asset('img/logo_sigsa.png') }}" class="img-responsive" width="300px;">
        <div class="flex items-center justify-end mt-4">
            <a href="{{ url('auth/google') }}">
                <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"
                    style="margin-left: 3em;">
            </a>
        </div>
    </div>

@endguest
