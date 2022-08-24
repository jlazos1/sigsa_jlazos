<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <title>Préstamo funcionario</title>
    <style>
        body {
            @page {
                size: letter;
                margin: 0;
            }
        }

    </style>
</head>

<body style="width: 90%;">
    <div class="container-fluid">
        <div class="row">
            <div class="col text-center">
                <img src="img/logo.png" alt="" width="100px">
                <h3>
                    COMPROBANTE DE DEVOLUCION
                </h3>
                <b>Identificador : # {{ $loan->id }}</b>
                <br>
                <b>Fecha de Préstamo : {{ $loan->delivery }}</b>
                <br>
                <b>Fecha de Devolución : {{ $loan->returned }}</b>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <h4>Prestatario</h4>
                @if ($loan->proxy_id)
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>Nombre Apoderado(a)</th>
                            <td>
                                {{ $loan->proxy_name . ' ' . $loan->proxy_lastname1 . ' ' . $loan->proxy_lastname2 }}
                            </td>
                        </tr>
                        <tr>
                            <th>R.U.N.</th>
                            <td>
                                {{ $loan->proxy_run }}
                            </td>
                        </tr>
                        <tr>
                            <th>Parentezco o Relación</th>
                            <td>
                                {{ $relationship->relationship }}
                            </td>
                        </tr>
                        <tr>
                            <th>Nombre de Estudiante</th>
                            <td>{{ $loan->student_name . ' ' . $loan->student_lastname1 . ' ' . $loan->student_lastname2 }}
                            </td>
                        </tr>
                        <tr>
                            <th>Curso</th>
                            <td>{{ $curso }}</td>
                        </tr>
                        <tr>
                            <th>Teléfono</th>
                            <td>{{ $loan->proxy_phone1 }}</td>
                        </tr>
                    </table>
                @else
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>Nombre funcionario(a)</th>
                            <td>
                                {{ $loan->user_name }}
                            </td>
                        </tr>
                        <tr>
                            <th>Correo-E</th>
                            <td>
                                {{ $loan->user_email }}
                            </td>
                        </tr>
                    </table>
                @endif

                <h4>Detalle de préstamo</h4>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Descripción</th>
                        <td>{{ $loan->item}}</td>
                    </tr>
                    <tr>
                        <th>Marca</th>
                        <td>{{ $loan->brand }}</td>
                    </tr>
                    <tr>
                        <th>Modelo</th>
                        <td>{{ $loan->model }}</td>
                    </tr>
                    <tr>
                        <th>Costo</th>
                        <td>$ {{ number_format($loan->price, 0, ',', '.') }}</td>
                    </tr>
                </table>

                <h4>Observaciones</h4>
                <p>{{ $loan->observations }}</p>
            </div>
        </div>
    </div>

</body>

</html>
