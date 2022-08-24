<?php

namespace App\Http\Livewire;

use App\Models\Basket;
use App\Models\Beneficiary;
use App\Models\Nomina;
use App\Models\Record;
use App\Models\Student;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CanastaComponent extends Component
{
    public $inputStudent, $inputCurso;
    public $student, $baskets;
    public $personRun, $personName, $observations;
    public $errorEntrega, $canastaEntregada;
    public $ultimoEntregado, $beneficiary, $advertencia;
    public $colorButton = "btn-success";
    public $textButton = "Entregar Canasta";

    public function buscar()
    {
        $this->advertencia = false;
        $this->student = Nomina::where("student", $this->inputStudent)->first();
        $this->baskets = Basket::where("student", $this->inputStudent)
            ->orderBy("created_at", "DESC")
            ->get();
        $this->ultimoEntregado = Basket::where("student", $this->inputStudent)
            ->max("created_at");
        $this->beneficiary = Beneficiary::where("studentRun", $this->student->run)->max("asignado");

        $fecha = new DateTime($this->beneficiary);
        $hoy = (new DateTime())->format("Y-m-d");

        if ($fecha->format("Y-m-d") > $hoy) {
            $this->advertencia = "ASIGNADO PARA EL $this->beneficiary";
        }
        if ($fecha->format("Y") == 1900) {
            $this->advertencia = "EN LISTA DE ESPERA";
        } elseif ($hoy > $fecha->format("Y-m-d")) {
            $this->advertencia = "NO TIENE CANASTA ASIGNADA";
        }

        if ($this->advertencia) {
            $this->colorButton = "btn-danger";
            $this->textButton = "Entrega Canasta excepcionalmente";
        } else {
            $this->colorButton = "btn-success";
            $this->textButton = "Entregar Canasta";
        }
    }

    public function render()
    {
        return view('livewire.canasta-component', [
            "cursos" => Record::getCursos(),
            "estudiantes" => Student::where("departament", $this->inputCurso)->get(),
            "ultimoEntregado" => $this->ultimoEntregado,
        ]);
    }

    public function limpiar()
    {
        $this->student = "";
        $this->baskets = "";
        $this->inputStudent = "";
        $this->inputCurso = "";
        $this->personRun = "";
        $this->personName = "";
        $this->observations = "";
        $this->errorEntrega = "";
        $this->advertencia = "";
        $this->ultimoEntregado = "";
        $this->beneficiary = "";
    }

    public function entregarCanasta()
    {
        $personRun = trim($this->personRun);
        $personName = trim($this->personName);

        if ($personRun and $personName and $this->student) {
            $basket = new Basket();
            $basket->course = trim($this->student->curso);
            $basket->email = trim($this->student->email);
            $basket->student = trim($this->student->student);
            $basket->run = trim($this->student->run);
            $basket->observations = trim($this->observations);
            $basket->personName = trim($this->personName);
            $basket->personRun = trim($this->personRun);
            $basket->user_id = Auth::user()->id;
            $basket->save();
            $this->limpiar();
        } else {
            $this->errorEntrega = "Nombre y RUN no pueden estar en blanco";
        }
    }
}
