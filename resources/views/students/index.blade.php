@extends('layouts.student')

@section('title')
    Estudiantes
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    Estudiantes
                    <a href=" {{ route('studentCreate') }} " class="btn btn-primary mb-2 float-right">
                        Nuevo Estudiante
                    </a>
                    <a href=" {{ route('studentsFileUpload') }}  " class="btn btn-primary mb-2 float-right">
                        Carga Masiva (Excel)
                    </a>
                </h2>
                <form action="{{ route('filterStudents') }}">
                    <div class="form-group">
                        <select name="year" id="year" class="form-control">
                            <option value="">Seleccione un año </option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <select name="course_id" id="course_id" class="form-control">
                            <option value="">Seleccione un curso</option>
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary mb-2 mt-2">Buscar</button>
                    </div>
                </form>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mb-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                @if (isset($students))
                    <table id="table_id" class="table table-striped table-hover display">
                        <thead class="thead">
                            <tr>
                                <th>Nombres</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Curso</th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->names }}</td>
                                    <td>{{ $student->lastname1 }}</td>
                                    <td>{{ $student->lastname2 }}</td>
                                    <td>
                                        <a href=" {{ route('showStudent', $student->id) }} " class="btn"> Ver
                                        </a>
                                        <a href=" {{ route('editStudent', $student->id) }} "
                                            class="btn">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection

<script>
    $(document).ready(function() {
        $('#table_id').DataTable({
            language: {
                url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            }
        });
    });
</script>
