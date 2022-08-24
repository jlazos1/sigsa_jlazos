@extends('layouts.app')

@section('template_title')
    Create Sector
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Sector</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('sectors.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('sector.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
