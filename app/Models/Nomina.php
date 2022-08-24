<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    use HasFactory;

    protected $fillable = [
        "curso", "number", "matricula", "run", "student", "name1", "name2", "lastname1", "lastname2", "genre", "birthday", "obs",
    ];

    public static function isNomina($hoja)
    {
        if ($hoja->getCell("A6") == "Nº" and $hoja->getCell("J6") == "OBS") {
            return true;
        }
        return false;
    }

    public static function getNumeroLista($student)
    {
        return Nomina::where("student", $student)->first()->number;
    }
}
