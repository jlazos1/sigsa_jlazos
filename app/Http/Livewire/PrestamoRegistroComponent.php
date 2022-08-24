<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\Product;
use App\Models\ProductType;
use Livewire\Component;

class PrestamoRegistroComponent extends Component
{
    public $run, $nombre, $apellidos, $direccion, $comuna, $telefono, $correo;
    public $comunas, $producto_tipos, $productos;
    public $producto_tipo, $producto, $cantidad, $fecha_entrega, $fecha_devolucion;
    public $section_paso1, $section_paso2, $section_paso3;
    public $valid_run;

    protected $rules = [
        "run" => "required",
        "nombre" => "required",
        "apellidos" => "required",
        "direccion" => "required",
        "comuna" => "required",
        "telefono" => "required",
        "correo" => "required|email",
    ];

    public function mount()
    {
        $this->section_paso1 = "";
        $this->section_paso2 = "hidden";
        $this->section_paso3 = "hidden";
        $this->comunas = ["Arica", "Camarones", "General Lagos", "Putre"];
        $this->producto_tipos = ProductType::all();
        $this->productos = [];
    }

    public function selectType()
    {
        $this->productos = Product::where("product_type_id", $this->producto_tipo)->get();
    }

    public function irPasoFinal()
    {
        $prestamo = new Document();
        $prestamo->type = "SALIDA";
        $prestamo->documentType = "PRESTAMO";
        $prestamo->deliveryDate = $this->fecha_entrega;
        $prestamo->returnDate = $this->fecha_devolucion;
    }

    public function irPaso3()
    {
        $this->section_paso1 = "hidden";
        $this->section_paso2 = "hidden";
        $this->section_paso3 = "";
    }

    public function irPaso2()
    {
        $this->validate();
        $this->valid_run = $this->validaRut($this->run) ? "is-valid" : "is-invalid";

        if ($this->valid_run == "is-valid") {
            $this->section_paso1 = "hidden";
            $this->section_paso2 = "";
            $this->section_paso3 = "hidden";
        }
    }

    public function irPaso1()
    {
        $this->section_paso1 = "";
        $this->section_paso2 = "hidden";
        $this->section_paso3 = "hidden";
    }


    public function validaRut($rut)
    {
        if (trim($rut) == "") {
            return false;
        }

        $rut = preg_replace('/[^k0-9]/i', '', $rut);
        $dv  = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut) - 1);

        if (!is_numeric($numero)) {
            return false;
        }

        $i = 2;
        $suma = 0;
        foreach (array_reverse(str_split($numero)) as $v) {
            if ($i == 8) {
                $i = 2;
            }

            $suma += $v * $i;
            ++$i;
        }

        $dvr = 11 - ($suma % 11);

        if ($dvr == 11) {
            $dvr = 0;
        }

        if ($dvr == 10) {
            $dvr = 'K';
        }

        if ($dvr == strtoupper($dv)) {
            return true;
        } else {
            return false;
        }
    }

    public function render()
    {
        return view('livewire.prestamo-registro-component');
    }
}
