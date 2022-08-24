@extends('layouts.user')

@section('title')
    Permisos
@endsection

@section('content')
    <div class="container-fluid mt-3 mb-3">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary mb-3" href="{{ route('userIndex') }}"> Volver </a>
                <form method="POST" action=" {{ route('savePermissions') }} ">
                    @csrf
                    
                    <div class="form-group">
                        <label for="">Seleccione los permisos</label><br>
                        @foreach ($roles as $rol)
                            <label><input type="checkbox" name="permisos[]" id="{{ $rol->id }}" value= {{ $rol->id }} class="m-2 p-3"
                                    @foreach ($permisos as $perm) 
                                        @if ($perm->rol_id == $rol->id)
                                            checked 
                                        @endif                                        
                                    @endforeach
                                > {{ $rol->name }} </label><br>

                        @endforeach
                    </div>
                    <input type="hidden" name="user" value=" {{$user->id}} ">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mt-2 m-2"> Guardar </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
