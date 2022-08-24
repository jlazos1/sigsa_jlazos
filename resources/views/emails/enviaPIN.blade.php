<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<div style="text-align: center;">
    <h1>Estimado(a), {{$student->name}}</h1>
    <h4>Se ha generado un PIN para que puedas votar por tu mejor compañero(a)</h4>
    <h1>PIN {{$pin}}</h1>
    <br>
    <p>
        Para votar solo debes acceder al siguiente link :<br>
        <a href="https://asistencia.colegiosaucache.cl/elecciones">
            https://asistencia.colegiosaucache.cl/elecciones
        </a>
        <br>
        Ingresar el PIN y tu correo electrónico institucional
        y luego a votar por tu mejor compañero(a)
    </p>
</div>
