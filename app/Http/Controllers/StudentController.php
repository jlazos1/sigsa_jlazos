<?php

namespace App\Http\Controllers;

use App\Imports\enrollmentsImport;
use App\Imports\studentsImport;
use App\Models\Course;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Course::all();

        return view("students.index", compact('cursos'));
    }

    public function filter(Request $request)
    {
        $students = DB::table('enrollments')
            ->join('students', 'enrollments.student_id', '=', 'students.id')
            ->select('students.*')
            ->where('year', $request->year)
            ->where('course_id', $request->course_id)
            ->get();
        $cursos = Course::all();

        return view("students.index", compact('students', 'cursos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("students.create");
    }

    public function newCreate()
    {
        $cursos = Course::all();

        return view("students.newCreate", compact('cursos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if ($request->hasFile("archivo")) {
                $archivo = $request->file("archivo");
                $fp = fopen($archivo, 'r');
                while (!feof($fp)) {
                    $linea = explode(",", fgets($fp));
                    if (isset($linea[1])) {
                        $nombre = $linea[6];
                        $curso = $linea[4];
                        $email = $linea[31];
                        $tipo = $linea[29];
                        if ($nombre != 'Nombre para mostrar' and $nombre != "") {
                            Student::updateOrCreate(["name" => $nombre], [
                                "departament" => $curso,
                                "email" => $email,
                                "type" => $tipo
                            ]);
                        }
                    }
                }
                fclose($fp);
            }
            return redirect()->back()->with("success", "Se ha cargado el archivo de asistencia sin errores");
        } catch (Exception $e) {
            echo $e . "<br>";
            // return redirect()->back()->with("errors", "Archivo corrupto : $e ");
        }
    }

    public function newStore(Request $request)
    {
        $request->validate([
            'run' => 'required',
            'name' => 'required',
            'lastname_1' => 'required',
            'lastname_2' => 'required',
            'curso_id' => 'required',
        ], [
            'run.required' => "Ingrese el RUN",
            'name.required' => "Ingrese el nombre",
            'lastname_1.required' => "Ingrese el primer apellido",
            'lastname_2.required' => "Ingrese el segundo apellido",
        ]);

        $student = new Student();
        $student->run = $request->input('run');
        $student->names = $request->input('name');
        $student->lastname1 = $request->input('lastname1');
        $student->lastname2 = $request->input('lastname2');
        $student->course_id = $request->input('curso_id');
        $student->name = $request->input('name') . " " . $request->input('lastname1') . " " . $request->input('lastname2'); 
        $student->save();

        return redirect()->route('students.index')
            ->with('success', 'Estudiante creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $estudiante = Student::find($id);
        return view("students.show", [
            "estudiante" => $estudiante
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

    public function isDuplicate($nombre)
    {
        $students = Student::where("name", $nombre)->get();
        if (count($students) > 0) {
            return true;
        }
        return false;
    }

    public function lista()
    {
        $estudiantes = Student::where("type", "ESTUDIANTE")->get();
        return view("students.list", [
            "estudiantes" => $estudiantes
        ]);
    }

    public function fileUpload()
    {
        return view("students.fileUpload");
    }

    public function saveImport(Request $request)
    {

        $request->validate([
            'archivo' => 'required|mimes:xlsx',
        ], [
            'archivo.required' => "Seleccione un archivo",
            'archivo.mimes' => "Seleccione un archivo Excel (XLSX)."
        ]);

        //Excel::queueImport(new ActivesImport, $request->file('archivo'));

        $file = $request->file('archivo');
        $import = new enrollmentsImport;
        $import->import($file);
        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return redirect()->route('studentsFileUpload')
            ->with('status', 'Estudiantes importados correctamente');
    }
}
