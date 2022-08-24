@extends('layouts.prestamo')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col text-center">
                <h1>Préstamo a Funcionario/Docente</h1>
                <form action="{{ route('confirma.funcionario') }}" method="post">
                    @csrf
                    @method("POST")
                    <div class="form-group col-md-6 offset-md-3">
                        <label>Seleccione Funcionario</label>
                        <select name="user_id" class="selectpicker form-control" data-live-search="true" required>
                            <option value="">Seleccione...</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" data-subtext="{{ $user->email }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label>Escoja el Producto</label>
                        <select name="product_id" class="selectpicker form-control" data-live-search="true" required>
                            <option value="">Seleccione...</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-subtext="{{ $product->sku }}">
                                    {{ $product->item }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label>Desde</label>
                        <input type="date" name="delivery" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label>Hasta</label>
                        <input type="date" name="return" class="form-control" required>
                    </div>
                    <button class="btn btn-success">
                        Siguiente
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
