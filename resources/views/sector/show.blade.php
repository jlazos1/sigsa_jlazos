@extends('layouts.app')

@section('template_title')
    {{ $sector->name ?? 'Show Sector' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Sector</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('sectors.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $sector->name }}
                        </div>
                        <div class="form-group">
                            <strong>Char:</strong>
                            {{ $sector->char }}
                        </div>
                        <div class="form-group">
                            <strong>Type:</strong>
                            {{ $sector->type }}
                        </div>
                        <div class="form-group">
                            <strong>Start:</strong>
                            {{ $sector->start }}
                        </div>
                        <div class="form-group">
                            <strong>End:</strong>
                            {{ $sector->end }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
