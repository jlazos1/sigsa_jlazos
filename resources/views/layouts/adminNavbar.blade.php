@auth
    <nav class="navbar navbar-expand-lg navbar-dark mb-3" style="background-color: darkred">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('img/logo_sigsa_blanco.png') }}" style="height:30px;" class="mt-0">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
                <a class="nav-link text-white" aria-current="page" href="{{ route('home') }}">Inicio</a>
                <a class="nav-link text-white" href="#" onclick="cerrarSesion()">
                    <i class="material-icons">exit_to_app</i>
                </a>
            </div>
        </div>
    </nav>


    <!-- Modal -->
    <div class="modal fade" id="cerrarModal" tabindex="-1" aria-labelledby="cerrarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h3>¿Realmente desea cerrar sesión?</h3>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        @method("POST")
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-danger">Si, cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cerrarSesion() {
            $("#cerrarModal").modal("show");
        }
    </script>

@endauth
