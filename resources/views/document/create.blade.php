@extends('layouts.inventario')

@section('title')
    Crear Documento
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3>Crear Documento</h3>
                @includeif('partials.errors')
                <form method="POST" action="{{ route('documents.store') }}">
                    @csrf
                    @include('document.form')
                </form>
            </div>
        </div>
    </section>
@endsection
