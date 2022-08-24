<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class enrollmentsImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $student_run = $row['run'] . " - " . $row['digito_ver'];
        $student = Student::where('run', $student_run)->first();
        if($student == null){
            $student = new Student();
            $student->name = $row['nombres'] . " " . $row['apellido_paterno'] . " " . $row['apellido_materno']; 
            $student->run = $student_run;
            $student->names = $row['nombres'];
            $student->lastname1 = $row['apellido_paterno'];
            $student->lastname2 = $row['apellido_materno'];
            $student->address = $row['direccion'];
            $student->genre = $row['genero'];
            $student->email = $row['email'];
            $student->save();
        }

        $nombre_curso = $row['desc_grado'] . " - " . $row['letra_curso']; 
        if($row['cod_tipo_ensenanza'] == 410){
            $nombre_curso = $nombre_curso . " TP"; 
        } 

        $curso = Course::where('name', $nombre_curso)->first();
        if($curso == null){
            $curso = new Course();
            $curso->name = $nombre_curso;
            $curso->save();
        }

        return new Enrollment([
            'course_id' => $curso->id,
            'student_id' => $student->id,
            'year' => $row['ano']
        ]);
    }

}
