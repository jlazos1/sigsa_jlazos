<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventarioController extends Controller
{

    public function prestamo_registrar()
    {
        return view("inventario.prestamo-registrar");
    }

    public function entrada_registrar()
    {
        return view("inventario.entrada-registrar");
    }

    public function config()
    {
        return view("inventario.config");
    }

    public function config_carga_productos()
    {
        return view("inventario.config-carga-productos");
    }
}
