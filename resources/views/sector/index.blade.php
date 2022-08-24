@extends('layouts.app')

@section('template_title')
    Sector
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Sector') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('sectors.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Name</th>
										<th>Char</th>
										<th>Type</th>
										<th>Start</th>
										<th>End</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sectors as $sector)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $sector->name }}</td>
											<td>{{ $sector->char }}</td>
											<td>{{ $sector->type }}</td>
											<td>{{ $sector->start }}</td>
											<td>{{ $sector->end }}</td>

                                            <td>
                                                <form action="{{ route('sectors.destroy',$sector->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('sectors.show',$sector->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('sectors.edit',$sector->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $sectors->links() !!}
            </div>
        </div>
    </div>
@endsection
