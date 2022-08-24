<?php

namespace App\Http\Livewire;

use App\Models\Pin;
use App\Models\Student;
use App\Models\Vote;
use Livewire\Component;

class BestPartner extends Component
{
    public $correo, $pin, $student, $success, $error;
    public $acceso = false;
    public $curso;
    public $candidate;

    public function ingresar()
    {
        $result = Pin::where("email", $this->correo)
            ->where("pin", $this->pin)
            ->first();

        if ($result) {
            $this->acceso = true;
            $this->student = Student::where("email", $result->email)->first();
            $this->curso = Student::where("departament", $this->student->departament)->get();
        } else {
            $this->error = "Correo electrónico o PIN incorrectos, consulte con su profesor. ";
        }
    }

    public function elegir()
    {
        $votoPasado = Vote::where("student", $this->student->email)->first();

        if (!$votoPasado) {
            $vote = new Vote();
            $vote->student = $this->student->email;
            $vote->candidate = $this->candidate;
            $vote->save();
            $this->success = $this->student->name . " su voto ha sido procesado correctamente";
        } else {
            $this->error = $this->student->name . " ya tiene un voto ingresado con fecha $votoPasado->created_at";
        }
    }

    public function render()
    {
        return view('livewire.best-partner');
    }
}
