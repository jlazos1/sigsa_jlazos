@extends('layouts.inventario')

@section('title')
    Documentos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 mt-3 mb-3">
                <h3>Listado Global de Documentos</h3>

                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Correcto! </strong> {{ session('success') }}.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>ADVERTENCIA! </strong> {{ session('error') }}.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <table id="table_id" class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>MOV</th>
                            <th>DOC</th>
                            <th>NUM</th>
                            <th>FECHA</th>
                            <th>Emisor</th>
                            <th>Receptor</th>
                            
                        
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $document)
                            <tr>
                                <td>
                                    @if ($document->type == 'ENTRADA')
                                        <span class="badge badge-info">ENTRADA</span>
                                    @else
                                        <span class="badge badge-warning">SALIDA</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        {{ $document->documentType }}
                                    </span>
                                </td>
                                <td>{{ $document->number }}</td>
                                <td>{{ (new DateTime($document->date))->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge badge-secondary" title="{{ $document->transmitterName }}">
                                        {{ $document->transmitterRut }}
                                    </span>
                                </td>
                                <td>
                                    <label class="badge badge-primary" title="{{ $document->receiverName }}">
                                        {{ $document->receiverRut }}
                                    </label>
                                </td>
                               
                                <td>
                                    <a class="btn btn-sm" title="Ver documento"
                                        href="{{ route('documents.show', $document->id) }}">
                                        <i class="material-icons">remove_red_eye</i>
                                    </a>
                                    <a class="btn btn-sm" title="Modificar documento"
                                        href="{{ route('documents.edit', $document->id) }}">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <button class="btn btn-sm" title="Eliminar"
                                        onclick="deleteModal({{ json_encode($document) }})">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- DeleteModal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-danger" id="deleteModalTitle">
                        Confirme eliminación
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="deleteModalMessage">
                </div>
                <div class="modal-footer">
                    <form id="formDeleteModal" method="post">
                        @csrf
                        @method("DELETE")
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Si, eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            function deleteModal(doc) {
                console.log(doc);
                let message = document.querySelector("#deleteModalMessage");
                message.innerHTML = "¿Realmente desea eliminar " + doc.documentType + " N°" + doc.number +
                    " correspondiente al emisor " + doc.transmitterName + " ?";
                document.querySelector("#formDeleteModal").action = "/inventario/documents/" + doc.id;
                $("#deleteModal").modal("show");
            }
        </script>
    @endpush

@endsection
