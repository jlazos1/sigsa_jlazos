<?php

namespace App\Http\Livewire;

use App\Models\Record;
use App\Models\Student;
use Livewire\Component;

class TeacherComponent extends Component
{
    public $profesores, $informe;
    public $profesor, $desde, $hasta, $horario;
    public $success, $error;

    public function mount()
    {
        $this->profesores = Student::where("type", "PROFESOR")
            ->orWhere("type", "ASISTENTE EDUCACION")
            ->get();
    }

    public function render()
    {
        return view('livewire.teacher-component');
    }

    public function buscarAsistencia()
    {
        $this->error = false;

        $profesor = $this->profesor;
        $desde = $this->desde;
        $hasta = $this->hasta;
        $horario = $this->horario;
        if (isset($profesor) and isset($desde) and isset($hasta)) {
            $this->informe = Record::asistenciaByProfesor($desde, $hasta, $profesor, $horario);
        } else {
            $this->error = "IMPORTANTE : Debe indicar fechas, horario y nombre del profesor";
        }
    }
}
