@extends('layouts.prestamo')

@section('title', 'Reportes')

@section('content')
    <div class="container">
        <div class="row bg-dark text-white mb-3 text-center">
            <div class="col-sm-3">
                <b>REPORTE GENERAL</b>
            </div>
            <div class="col-sm-3">
                TOTAL PRESTAMOS : {{ $report['total'] }}
            </div>
            <div class="col-sm-3">
                ACTIVOS : {{ $report['activos'] }}
            </div>
            <div class="col-sm-3">
                DEVUELTOS : {{ $report['devueltos'] }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Reporte de Entrega/Devolución de Préstamos</h2>
                <form action="{{ route('prestamo.reporte.curso') }}" method="post">
                    @csrf
                    @method("POST")
                    <div class="form-group">
                        <label>Cursos</label>
                        <select class="form-control selectpicker" data-live-search="true" name="curso_id" required>
                            <option value="">Seleccione...</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Año</label>
                        <select class="form-control selectpicker" data-live-search="true" name="anio" required>
                            <option value="">Seleccione...</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
