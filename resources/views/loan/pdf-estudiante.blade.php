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
                    CERTIFICADO DE PRÉSTAMO EN COMODATO
                </h3>
                <b>Identificador : # {{ $data['loan_id'] }}</b>
                <br>
                <b>Fecha : {{ $data['desde'] }}</b>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col" style="text-align: justify;">
                <p>
                    Denominado como “el contrato” que celebra por una parte Colegio Saucache de Arica C.E. en adelante
                    nombrada como “el comodante”, y por la otra parte EL APODERADO(a) denominado en lo sucesivo “el
                    comodatario”, identificado por los siguientes datos:
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Nombre Apoderado(a)</th>
                        <td>
                            {{ $data['proxy']->name1 .' ' .$data['proxy']->name2 .' ' .$data['proxy']->lastname1 .' ' .$data['proxy']->lastname2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>R.U.N.</th>
                        <td>
                            {{ $data['proxy']->run }}
                        </td>
                    </tr>
                    <tr>
                        <th>Parentezco o Relación</th>
                        <td>
                            {{ $data['relationship'] }}
                        </td>
                    </tr>
                    <tr>
                        <th>Nombre de Estudiante</th>
                        <td>{{ $data['student']->name }}</td>
                    </tr>
                    <tr>
                        <th>Curso</th>
                        <td>{{ $data['student']->enrollments->last()->course->name }}</td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td>{{ $data['proxy']->phone1 }}</td>
                    </tr>
                </table>

                <div class="row">
                    <div class="col text-center">
                        <u><b>CLÁUSULAS</b></u>
                    </div>
                </div>
                <p style="text-align: justify;">
                    <b>PRIMERO : </b>
                    EL COMODANTE otorga en calidad de PRÉSTAMO de lo que se detalla a continuación:
                </p>

                <table class="table table-bordered table-sm">

                    <tr>
                        <th>Descripción</th>
                        <td>{{ $active->item }}</td>
                    </tr>
                    <tr>
                        <th>Marca</th>
                        <td>{{ $active->brand }}</td>
                    </tr>
                    <tr>
                        <th>Modelo</th>
                        <td>{{ $active->model }}</td>
                    </tr>
                    <tr>
                        <th>Costo</th>
                        <td>$ {{ number_format($data['details']->price, 0, ',', '.') }}</td>
                    </tr>
                </table>

            </div>
        </div>
        <div class="row">
            <div class="col" style="text-align: justify;">
                <p>
                    <b>SEGUNDA : </b>
                    EL COMODANTE manifiesta que el bien prestado deberá ser utilizado con fines EDUCATIVOS detallados en
                    el Reglamento de Evaluación y Promoción y Manual de Convivencia Escolar vigentes en el Colegio,
                    disponibles en www.colegiosaucache.cl, resultando estrictamente prohibido que otra persona
                    cualquiera, bajo ninguna circunstancia, le dé otro uso, de esta manera queda prohibido cualquier
                    tipo de cesión, préstamo a terceras personas o venta del bien, se exige la participación del pupilo
                    al menos a un 85% de las clases virtuales y cumplimiento de sus deberes académicos.
                </p>

                <p>
                    <b>TERCERA : </b>
                    EL COMODATARIO manifiesta su conformidad con la transmisión y el uso de dicho bien, quedando en la
                    obligación a poner toda la diligencia posible en la conservación del mismo e informar fallas o
                    desperfectos y/o reposiciones necesarias que se precisen tras algún accidente causado por éste al
                    bien en préstamo.
                </p>

                <p>
                    <b>CUARTA : </b>
                    El contrato tendrá vigencia el Año Lectivo 2021 a partir de la fecha de la firma de este contrato
                    teniendo que devolver el bien a final de año donde se revisará las condiciones de entrega del mismo.
                </p>


                <p>
                    <b>QUINTA : </b>
                    El servicio de conectividad a internet tiene una capacidad de 50gb mensuales, con la empresa de
                    telecomunicaciones Claro Chile, esta conectividad está sujeta a la disponibilidad de la red en las
                    zonas urbanas y rurales que entrega la empresa. A través de la empresa se hará un monitoreo del uso
                    del plan otorgado.
                </p>

                <p>
                    <b>SEXTA : </b>
                    Las partes convienen que, al término de la vigencia de este contrato, EL COMODATARIO, sin necesidad
                    de necesidad de algún instrumento jurídico, se obliga a entregar a EL COMODANTE, los bienes que
                    estaban en calidad de préstamo, con el sólo deterioro que pueda haberlos afectado el uso cotidiano.
                </p>

                <p>
                    Declaro haber leído el presente contrato en su totalidad y aceptadas las cláusulas de su contenido y
                    alcances.
                </p>
                <p>
                    Lo firman en ARICA, con fecha : {{ (new DateTime($data['created_at']))->format('d-m-Y') }}
                </p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <table style="font-size: small; text-align: center; width:100%;">
                    <tr>
                        <td>
                            <img src="img/firma-director.png" alt="" style="width:200px;">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:text-top; text-align:center;">
                            Guillermo Quintanilla Muñoz<br>
                            Director Colegio Saucache <br>
                            Comodante <br>
                            (Firma)
                        </td>
                        <td style="vertical-align:text-top; text-align:center;">
                            {{ $data['proxy']->name1 .' ' .$data['proxy']->name2 .' ' .$data['proxy']->lastname1 .' ' .$data['proxy']->lastname2 }}
                            <br>Comodatario<br>
                            (Firma)
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
