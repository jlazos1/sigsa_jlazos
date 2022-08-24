@extends('layouts.asistencia')
@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <h1>Asistencia por estudiante</h1>
            <form action="" method="post">
                @csrf
                @method("GET")
                <div class="form-group">
                    <label>Curso</label>
                    <select name="departament" class="form-control" onchange="listaEstudiantes(this.value);" required>
                        <option value="">Seleccione...</option>
                        @foreach ($cursos as $c)
                        <option value="{{$c->departament}}" {{$curso == $c->departament ? "selected":""}}>
                            {{$c->departament}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Estudiante</label>
                    <input id="student" type="text" class="form-control" name="student" value="{{$student ?? ""}}"
                        list="students" autocomplete="off">
                    <datalist id="students">
                    </datalist>
                </div>
                <div class="form-group">
                    <label></label>
                    <button class="btn btn-success form-control">
                        Buscar
                    </button>
                </div>
            </form>
            @if (isset($error))
            <div class="alert alert-danger mt-3">
                {{$error}}
            </div>
            @endif
        </div>
    </div>
    @if (count($asistencia)>0)
    <div class="row mt-3">
        <div class="col">
            <h3>Resumen</h3>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Día</th>
                        <th class="text-center">B1</th>
                        <th class="text-center">B2</th>
                        <th class="text-center">B3</th>
                        <th class="text-center">B4</th>
                        <th class="text-center">B5</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">%</th>
                    </tr>
                </thead>
                @foreach ($asistencia as $a)
                <tr>
                    <th>{{ (new DateTime($a["dia"]))->format("d-m-Y, D") }}</th>
                    <td class="text-center">
                        @if($a["bloque1"])
                        <span class="material-icons text-success">check</span>
                        @else
                        <span class="material-icons text-danger">close</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($a["bloque2"])
                        <span class="material-icons text-success">check</span>
                        @else
                        <span class="material-icons text-danger">close</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($a["bloque3"])
                        <span class="material-icons text-success">check</span>
                        @else
                        <span class="material-icons text-danger">close</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($a["bloque4"])
                        <span class="material-icons text-success">check</span>
                        @else
                        <span class="material-icons text-danger">close</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($a["bloque5"])
                        <span class="material-icons text-success">check</span>
                        @else
                        <span class="material-icons text-danger">close</span>
                        @endif
                    </td>
                    <td>
                        {{ ($a["bloque1"]+$a["bloque2"]+$a["bloque3"]+$a["bloque4"]+$a["bloque5"]) }}
                    </td>
                    <td>
                        {{ ($a["bloque1"]+$a["bloque2"]+$a["bloque3"]+$a["bloque4"]+$a["bloque5"])*100/5 }}%
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endif
</div>

<script>
    function listaEstudiantes(curso){
        let students = {!! $estudiantes !!};
        let filtro = students.filter(student => student.departament == curso);
        let datalist = document.querySelector("#students");
        document.querySelector("#student").value="";
        datalist.innerHTML = "";
        filtro.map(item => {
            let option = document.createElement("option");
            option.value = item.name;
            datalist.appendChild(option);
        });
    }

    function buscar(){
        let student = document.querySelector("#student").value;
        location.href = "/admin/registros/estudiante/"+student;
    }
</script>

@endsection
