@extends('layouts.prestamo')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col text-center">
                <h1>Préstamo a Estudiante</h1>
                <form id="formLoan" action="{{ route('confirma.estudiante') }}" method="post">
                    @csrf
                    @method("POST")
                    <div class="form-group col-md-6 offset-md-3">
                        <label>Escoja al estudiante</label>
                        <select id="student_id" name="student_id" class="form-control selectpicker" data-live-search="true"
                            required onchange="selectProxy(this.value)">
                            <option value="">Seleccione...</option>
                            @foreach ($students as $student)
                                @if ($student->enrollments->last()->year == date('Y'))
                                    <option value="{{ $student->id }}"
                                        data-subtext="{{ $student->enrollments->last()->course->name }}">
                                        {{ $student->names . ' ' . $student->lastname1 . ' ' . $student->lastname2 }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label>Seleccione al apoderado(a)
                            <button class="btn btn-link" type="button" onclick="modalProxyForm()">
                                Nuevo
                            </button>
                        </label>
                        <select name="proxy_id" id="proxy_id" class="form-control" required>
                        </select>
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label>Seleccione el Producto</label>
                        <select name="product_id" class="selectpicker form-control" data-live-search="true" required>
                            <option value="">Seleccione...</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-subtext="{{ $product->code }}">
                                    {{ $product->item }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label>Valor del Producto</label>
                        <input type="number" name="precio" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label>Indique fecha de inicio del préstamo</label>
                        <input type="date" name="delivery" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label>Indique fecha de término del préstamo</label>
                        <input type="date" name="return" class="form-control" required>
                    </div>
                    <button id="createLoan" type="submit" class="btn btn-success">
                        <span id="spinner" hidden class="spinner-border spinner-border-sm" role="status"
                            aria-hidden="true"></span>
                        Crear préstamo
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalProxyForm" tabindex="-1" aria-labelledby="modalProxyFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalProxyFormLabel">
                        Agregar apoderado(a) para : <br>
                        <label id="student_modal"></label>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row" id="proxyForm" action="{{ route('proxies.store') }}" method="post">
                        @csrf
                        @method("POST")
                        <input type="hidden" id="student_id_modal" name="student_id">
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Parentezco</label>
                            <select class="form-control" name="relationship" id="" required>
                                <option value="">Seleccione...</option>
                                <option value="PADRE">PADRE</option>
                                <option value="MADRE">MADRE</option>
                                <option value="ABUELO">ABUELO</option>
                                <option value="ABUELA">ABUELA</option>
                                <option value="TIO">TIO</option>
                                <option value="TIA">TIA</option>
                                <option value="HERMANA">HERMANA</option>
                                <option value="HERMANO">HERMANO</option>
                                <option value="TUTOR">TUTOR</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">RUN</label>
                            <input class="form-control" type="text" id="run" name="run" required
                                onblur="findProxy(this.value)" value="{{ old('run') ?? '' }}">
                            @error('run')
                                <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Primer Nombre</label>
                            <input class="form-control" type="text" id="name1" name="name1" required
                                value="{{ old('name1') ?? '' }}">
                            @error('name1')
                                <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Segundo Nombre</label>
                            <input class="form-control" type="text" id="name2" name="name2"
                                value="{{ old('name2') ?? '' }}">
                            @error('name2')
                                <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Primer Apellido</label>
                            <input class="form-control" type="text" id="lastname1" name="lastname1" required
                                value="{{ old('lastname1') ?? '' }}">
                            @error('lastname1')
                                <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Segundo Apellido</label>
                            <input class="form-control" type="text" id="lastname2" name="lastname2" required
                                value="{{ old('lastname2') ?? '' }}">
                            @error('lastname2')
                                <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Telefono 1</label>
                            <input class="form-control" type="number" id="phone1" name="phone1" required
                                value="{{ old('phone1') ?? '' }}">
                            @error('phone1')
                                <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Telefono 2</label>
                            <input class="form-control" type="number" id="phone2" name="phone2"
                                value="{{ old('phone2') ?? '' }}">
                            @error('phone2')
                                <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Correo-E</label>
                            <input class="form-control" type="email" id="email" name="email"
                                value="{{ old('email') ?? '' }}">
                            @error('email')
                                <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Dirección</label>
                            <input class="form-control" type="text" id="address" name="address"
                                value="{{ old('address') ?? '' }}" required>
                            @error('address')
                                <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">Ciudad</label>
                            <input class="form-control" type="text" id="city" name="city"
                                value="{{ old('city') ?? '' }}">
                            @error('city')
                                <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6 col-md-4">
                            <label for="">País</label>
                            <input class="form-control" type="text" id="country" name="country"
                                value="{{ old('country') ?? '' }}">
                            @error('country')
                                <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector("#formLoan").addEventListener("submit", function() {
            document.querySelector("#createLoan").disabled = true;
            document.querySelector("#spinner").hidden = false;
        });

        function selectProxy(student) {
            document.getElementById("proxy_id").innerHTML = "";
            $.get("/getProxies/" + student, function(data) {
                let proxies = data;
                proxies.map(proxy => {
                    let option = document.createElement("option");
                    option.value = proxy.id;
                    option.innerHTML = proxy.name1 + " " + proxy.lastname1 + " " + proxy.lastname2 +
                        " <small>(" + proxy.pivot.relationship + ")</small>";
                    document.getElementById("proxy_id").appendChild(option);
                })
            });
        }

        function modalProxyForm() {
            let student_id = document.querySelector("#student_id").value;
            if (student_id) {
                $.get("/getStudent/" + student_id, function(data) {
                    let student = data;
                    document.querySelector("#student_modal").innerHTML = student.name;
                    document.querySelector("#student_id_modal").value = student.id;

                    $("#modalProxyForm").modal("show");
                })
            } else {
                alert("Primero seleccione un estudiante")
            }
        }

        function findProxy(id) {
            $.get("/getProxy/" + id, function(data) {
                let proxy = data;
                if (proxy.run) {
                    document.querySelector("#run").value = proxy.run;
                    document.querySelector("#name1").value = proxy.name1;
                    document.querySelector("#name2").value = proxy.name2;
                    document.querySelector("#lastname1").value = proxy.lastname1;
                    document.querySelector("#lastname2").value = proxy.lastname2;
                    document.querySelector("#phone1").value = proxy.phone1;
                    document.querySelector("#phone2").value = proxy.phone2;
                    document.querySelector("#email").value = proxy.email;
                    document.querySelector("#address").value = proxy.address;
                    document.querySelector("#city").value = proxy.city;
                    document.querySelector("#country").value = proxy.country;
                }
            })
        }
    </script>
@endsection
