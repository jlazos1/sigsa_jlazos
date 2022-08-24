@extends('layouts.student')

@section('title')
    Nuevo Estudiante
@endsection

@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2>Nuevo Estudiante</h2>
                <form method="POST" action="{{ route('studentStore') }}">
                    @csrf
                    @method("POST")

                    <div class="form-group mt-1">
                        <label>RUN</label>
                        <input class="form-control" type="text" name='run'
                            value="{{ old('run') ?? '' }}">
                        @error('run')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-1">
                        <label for="">Nombres</label>
                        <input class="form-control" type="text" name='name' value="{{ old('name') ?? '' }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-1">
                        <label for="">Primer Apellido</label>
                        <input class="form-control" type="text" name='lastname1' value="{{ old('lastname1') ?? '' }}">
                        @error('lastname1')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-1">
                        <label for="">Segundo Apellido</label>
                        <input class="form-control" type="text" name='lastname2' value="{{ old('lastname2') ?? '' }}">
                        @error('lastname2')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    <div class="form-group mt-1">
                        <label>Curso</label>
                        <select name="curso_id" id="curso_id" class="form-control">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($cursos as $c)
                                <option value="{{ $c->id }}"> {{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('curso_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    

                    <div class="box-footer mt-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
