<?php

namespace App\Http\Livewire;

use App\Models\Basket;
use DateTime;
use Livewire\Component;

class ReportesCanasta extends Component
{
    public $nivel, $fecha;
    public $errorBuscar;
    public $informe;

    public function buscar()
    {
        $nivel = $this->nivel;
        $fecha = new DateTime($this->fecha);
        $informe = false;

        if ($nivel and $fecha) {
            $informe = Basket::whereDate("created_at", $fecha->format("Y-m-d"))
                ->get();
        } else {
            $this->errorBuscar = "Debe seleccionar fecha y nivel";
        }

        $this->informe = $informe;
    }

    public function render()
    {
        return view('livewire.reportes-canasta');
    }
}
