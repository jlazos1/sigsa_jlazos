<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Préstamo funcionario</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col text-center">
                <img src="img/logo.png" alt="" width="100px">
                <h3>Comprobante de Préstamo</h3>
                <b>Identificador : # {{ $data['loan_id'] }}</b>
                <br>
                <b>Fecha : {{ $data['desde'] }}</b>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <br><br>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th colspan="2">PERSONA RESPONSABLE</th>
                    </tr>
                    <tr>
                        <td>Nombre y Apellido</td>
                        <td>{{ $data['user']->name }}</td>
                    </tr>
                    <tr>
                        <td>Correo-E</td>
                        <td>{{ $data['user']->email }}</td>
                    </tr>
                    <tr>
                        <td>Teléfono</td>
                        <td>{{ $data['user']->phone }}</td>
                    </tr>
                </table>

                <table class="table table-bordered table-sm">
                    <tr>
                        <th>EQUIPOS/PRODUCTOS</th>
                    </tr>
                    <tr>
                        <td>{{ '1 x ' . $active->item }}</td>
                    </tr>
                </table>

            </div>
        </div>
        <div class="row">
            <div class="col">
                En caso eventual de extravío, pérdida, robo o hurto, al firmar este comprobante, usted declara el
                compromiso de retribución del equipo registrado en esta solicitud.
            </div>
        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <br>
                <br>
                <br>
                <br>
                ________________________________________<br>
                {{ $data['user']->name }}
                <br>
                (Firma)
            </div>
        </div>
    </div>


</body>

</html>
