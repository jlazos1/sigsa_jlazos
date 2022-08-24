<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class studentsImport implements
    ToModel,
    SkipsOnError,
    SkipsOnFailure,
    WithValidation,
    WithHeadingRow
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        dd($row);

        if($row['cod_tipo_ensenanza'] == 410){
            $nombre_curso = $row['desc_grado'] . " - " . $row['letra_curso'] . " TP"; 
        } else {
            $nombre_curso = $row['desc_grado'] . " - " . $row['letra_curso']; 
        }

        $curso = Course::where('name', );
        


        return new Student([
            'name' => $row['nombres'],
            'run' => $row['run'] . " - " . $row['digito_ver.'],
            'lastname1' => $row['apellido_paterno'],
            'lastname2' => $row['apellido_materno'],
            'address' => $row['direccion'],
            'genre' => $row['genero'],
            'email' => $row['email'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.run' => ['unique:students,run']
        ];
    }

    public function customValidationMessages()
    {
        return [
            'run.unique' => 'El RUN se encuentra duplicado',
        ];
    }
}
