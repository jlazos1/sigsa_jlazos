<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;

    protected $fillable = [
        "studentRun",
        "studentName",
        "studentEmail",
        "curso",
        "asignado",
        "reasignado",
        "observations",
    ];

    public static function recognizeFile($file)
    {
        if (
            $file->getCell("A1") == "NOMINA BENEFICIARIOS JUNAEB"
            and $file->getCell("A3") == "NIVEL"
            and $file->getCell("B3") == "RUN"
            and $file->getCell("C3") == "FECHA"
            and $file->getCell("D3") == "ESTADO"
        ) {
            return true;
        }
        return false;
    }
}
