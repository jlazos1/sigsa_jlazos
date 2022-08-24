<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Record;
use App\Models\Student;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Asistencia extends Component
{
    public $cursos, $curso, $fecha, $informe, $totales;
    public $error;
    public $ausentes;
    public $temporal = array(), $bloqueTemp;

    public function mount()
    {
        $this->fecha = (new DateTime())->format("Y-m-d");
    }

    public function render()
    {
        // $this->cursos = Record::getCursos();
        $this->cursos = Course::all();
        return view('livewire.asistencia');
    }

    public function buscarAsistencia()
    {
        $curso = $this->curso;
        $fecha = $this->fecha;
        if (isset($curso) and isset($fecha)) {
            $this->informe = Record::getAsistenciaByCurso($curso, $fecha, $fecha);
            $this->ausentes = Record::getAusentes2($this->informe);
            // $this->totales = Record::totalesAsistencia($this->informe);
            $this->error = false;
        } else {
            $this->error = "IMPORTANTE : Debe indicar fecha y curso";
        }
    }

    public function changeRecord($key, $item, $bloque)
    {
        // 0=AUSENTE ; 1=REMOTO ; 2=FISICO;
        $asistencia = $item["asistencia"][0]["bloque" . $bloque];
        if ($asistencia == 1) {
            $this->informe[$key]["asistencia"][0]["bloque" . $bloque] = 0;
        } elseif ($asistencia == 2) {
            $this->informe[$key]["asistencia"][0]["bloque" . $bloque] = 1;
        } else {
            $this->informe[$key]["asistencia"][0]["bloque" . $bloque] = 2;
        }

        $this->informe[$key]["asistencia"][0]["temp" . $bloque] = true;
        $this->temporal[$key] = $this->informe[$key];
    }

    public function testing()
    {
        dd($this->temporal);
    }

    public function updateRecords()
    {
        $horario = [
            "bloque1" => ["inicio" => "07:45", "termino" => "08:45"],
            "bloque2" => ["inicio" => "09:05", "termino" => "10:05"],
            "bloque3" => ["inicio" => "10:25", "termino" => "11:25"],
            "bloque4" => ["inicio" => "11:45", "termino" => "12:45"],
            "bloque5" => ["inicio" => "15:00", "termino" => "16:00"],
        ];

        $registros = $this->temporal;

        foreach ($registros as $item) {
            $estudiante = $item["estudiante"];
            $student = Student::findTotal($item["estudiante"]);

            $bloque1 = $item["asistencia"][0]["bloque1"];
            $bloque2 = $item["asistencia"][0]["bloque2"];
            $bloque3 = $item["asistencia"][0]["bloque3"];
            $bloque4 = $item["asistencia"][0]["bloque4"];
            $bloque5 = $item["asistencia"][0]["bloque5"];

            $temp1 = isset($item["asistencia"][0]["temp1"]) ?? false;
            $temp2 = isset($item["asistencia"][0]["temp2"]) ?? false;
            $temp3 = isset($item["asistencia"][0]["temp3"]) ?? false;
            $temp4 = isset($item["asistencia"][0]["temp4"]) ?? false;
            $temp5 = isset($item["asistencia"][0]["temp5"]) ?? false;

            if ($temp1) {
                $this->deleteRecord($estudiante, $horario["bloque1"]);
                $record = new Record();
                $record->student = $student->name;
                $record->student_id = $student->id;
                $record->course_id = $student->enrollments->last()->course_id;
                $record->fecha = $this->fecha;
                $record->teacher = Auth::user()->name;
                $record->hora = $horario["bloque1"]["inicio"];
                $record->action = $bloque1 == 1 ? "REMOTO" : "PRESENCIAL";
                if ($bloque1 > 0) {
                    $record->save();
                } else {
                    $this->deleteRecord($estudiante, $horario["bloque1"]);
                }
            }

            if ($temp2) {
                $this->deleteRecord($estudiante, $horario["bloque2"]);
                $record = new Record();
                $record->student = $student->name;
                $record->student_id = $student->id;
                $record->course_id = $student->enrollments->last()->course_id;
                $record->fecha = $this->fecha;
                $record->teacher = Auth::user()->name;
                $record->hora = $horario["bloque2"]["inicio"];
                $record->action = $bloque2 == 1 ? "REMOTO" : "PRESENCIAL";
                if ($bloque2 > 0) {
                    $record->save();
                } else {
                    $this->deleteRecord($estudiante, $horario["bloque2"]);
                }
            }

            if ($temp3) {
                $this->deleteRecord($estudiante, $horario["bloque3"]);
                $record = new Record();
                $record->student = $student->name;
                $record->student_id = $student->id;
                $record->course_id = $student->enrollments->last()->course_id;
                $record->fecha = $this->fecha;
                $record->teacher = Auth::user()->name;
                $record->hora = $horario["bloque3"]["inicio"];
                $record->action = $bloque3 == 1 ? "REMOTO" : "PRESENCIAL";
                if ($bloque3 > 0) {
                    $record->save();
                } else {
                    $this->deleteRecord($estudiante, $horario["bloque3"]);
                }
            }

            if ($temp4) {
                $this->deleteRecord($estudiante, $horario["bloque4"]);
                $record = new Record();
                $record->student = $student->name;
                $record->student_id = $student->id;
                $record->course_id = $student->enrollments->last()->course_id;
                $record->fecha = $this->fecha;
                $record->teacher = Auth::user()->name;
                $record->hora = $horario["bloque4"]["inicio"];
                $record->action = $bloque4 == 1 ? "REMOTO" : "PRESENCIAL";
                if ($bloque4 > 0) {
                    $record->save();
                } else {
                    $this->deleteRecord($estudiante, $horario["bloque4"]);
                }
            }

            if ($temp5) {
                $this->deleteRecord($estudiante, $horario["bloque5"]);
                $record = new Record();
                $record->student = $student->name;
                $record->student_id = $student->id;
                $record->course_id = $student->enrollments->last()->course_id;
                $record->fecha = $this->fecha;
                $record->teacher = Auth::user()->name;
                $record->hora = $horario["bloque5"]["inicio"];
                $record->action = $bloque5 == 1 ? "REMOTO" : "PRESENCIAL";
                if ($bloque5 > 0) {
                    $record->save();
                } else {
                    $this->deleteRecord($estudiante, $horario["bloque5"]);
                }
            }
        }
        $this->buscarAsistencia();
        $this->temporal = array();
        $this->emit("finishUpdate");
    }

    public function deleteRecord($student, $bloque)
    {
        Record::where("student", $student)
            ->where("fecha", $this->fecha)
            ->where("hora", ">=", $bloque["inicio"])
            ->where("hora", "<=", $bloque["termino"])
            ->delete();
    }
}
