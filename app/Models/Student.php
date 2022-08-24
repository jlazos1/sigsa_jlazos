<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "run",
        'lastnmame1',
        'lastname2',
        "email",
        "type",
        "address",
        "genre"
    ];

    public static function getCorreo($nombre)
    {
        $student = Student::where("name", $nombre)->first();
        if ($student) {
            return $student->email;
        }
        return false;
    }

    public static function getByRun($run)
    {
        $studentNomina = Nomina::where("run", $run)->first();
        if ($studentNomina) {
            $student = Student::where("name", $studentNomina->student)->first();
        }
        return $student ?? null;
    }

    // Reklaciones
    public function proxies()
    {
        return $this->belongsToMany(Proxy::class)->withPivot("relationship");
    }

    public function enrollment()
    {
        return $this->hasOne(Enrollment::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    //asistencia
    public function records()
    {
        return $this->hasmany(Record::class);
    }

    public function getCursoActual()
    {
        $enrollments = $this->enrollments;
        foreach ($enrollments as $e) {
        }
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public static function findTotal($valor)
    {
        $student = Student::where("name", $valor)
            ->orWhere("email", $valor)
            ->orWhere("run", $valor)
            ->first();
        return $student;
    }
}
