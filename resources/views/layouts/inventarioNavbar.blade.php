@auth
    <nav class="navbar navbar-expand-lg navbar-dark mb-3" style="background-color: darkgreen;">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('img/logo_sigsa_blanco.png') }}" alt="" width="150px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
                <a class="nav-link text-white" href="{{ asset('inventario') }}">Inicio</a>
                <a class="nav-link text-white" href="{{ route('products.index') }}">Productos</a>
                <a class="nav-link text-white" href="{{ route('actives.index') }}">Activos</a>
                <a class="nav-link text-white" href="{{ route('product_types.index') }}">Tipos de Producto</a>
                <a class="nav-link text-white" href="{{ route('providers.index') }}">Proveedores</a>
                <a class="nav-link text-white text-white" href="{{ route('inventario.config') }}">
                    <i class="material-icons">settings</i>
                </a>
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
