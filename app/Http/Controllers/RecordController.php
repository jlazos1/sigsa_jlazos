<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Student;
use DateTime;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile("archivos")) {
            $archivos = $request->file("archivos");
            $cant = count($archivos);
            if ($cant > 15) {
                return redirect()->back()->with("error", "Solo puede cargar hasta 15 archivos al mismo tiempo. Por favor seleccione menos archivos.");
            }
            foreach ($archivos as $archivo) {
                $fp = fopen($archivo, 'r');
                $typeFile = $this->recognizeFile($fp);

                if ($typeFile == "asistencia") {
                    Record::storeAsistenciaFile($fp);
                }

                if ($typeFile == "resumen") {
                    Record::storeResumenFile($fp);
                }

                fclose($fp);
            }
        }
        return redirect()->back()->with("success", "Se ha cargado $cant archivo(s) con éxito");
    }

    public function asistencia_manual()
    {
        return view("records.asistencia_manual");
    }

    public function recognizeFile($csv)
    {
        while (!feof($csv)) {
            $linea = explode("\t", fgets($csv));
            $f1c1 = mb_convert_encoding($linea[0], "utf-8", "utf-16");
            if ($f1c1 == 'Nombre completo') {
                return "asistencia";
            }
            if ($f1c1 == 'Resumen de la reunión') {
                return "resumen";
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }

    public function reporte_estudiante(Request $request)
    {
        $student = $request->student;
        $curso = $request->departament ?? "";
        $asistencia = [];
        $estudiante = null;
        $estudiantes = Student::where("type", "ESTUDIANTE")->get();
        $cursos = Record::getCursos();

        if (isset($student)) {
            $estudiante = Student::where("name", $student)->first();
            if (!isset($estudiante)) {
                return view("records.reporte_estudiante", [
                    "asistencia" => $asistencia,
                    "estudiante" => $estudiante,
                    "estudiantes" => $estudiantes,
                    "cursos" => $cursos,
                    "curso" => $curso,
                    "student" => $student,
                    "error" => "No se encuentra a $student en la base de datos.",
                ]);
            }
            $desde = (new DateTime("2021-03-04"))->format("Y-m-d");
            $hasta = (new DateTime())->format("Y-m-d");
            $asistencia = Record::asistenciaByAlumno($desde, $hasta, $estudiante->name);
        }

        return view("records.reporte_estudiante", [
            "asistencia" => $asistencia,
            "estudiante" => $estudiante,
            "estudiantes" => $estudiantes,
            "cursos" => $cursos,
            "curso" => $curso,
            "student" => $student,
        ]);
    }

    public function reporte_curso(Request $request)
    {
        $curso = $request->curso ?? false;
        $desde = $request->desde ?? (new DateTime())->format("Y-m-d");
        $hasta = $request->hasta ?? (new DateTime())->format("Y-m-d");
        $informe = array();

        $cursos = Record::getCursos();

        if ($curso) {
            $informe = Record::getAsistenciaByCurso($curso, $desde, $hasta);
            $totales = Record::totalesAsistencia($informe);
            $ausentes = Record::getAusentes($curso, $desde, $hasta);
        }

        return view("records.reporte_curso", [
            "cursos" => $cursos,
            "informe" => $informe ?? null,
            "totales" => $totales ?? null,
            "curso" => $curso ?? "",
            "desde" => $desde ?? (new DateTime())->format("Y-m-d"),
            "hasta" => $hasta ?? (new DateTime())->format("Y-m-d"),
            "ausentes" => $ausentes ?? false,
        ]);
    }

    public function excelAsistenciaCurso()
    {
        // Excel::create("Reporte Actividad Clientes", function ($excel) use ($informe) {
        //     $excel->setTitle('Informe Asistencia por Curso');
        //     $excel->setCreator('Alberto Medina Mazuelos')
        //         ->setCompany('Colegio Saucache de Arica');
        //     $excel->setDescription('Informe Asistencia por Curso');
        //     $excel->sheet("Principal", function ($sheet) use ($informe) {
        //         // $sheet->cell("A1", "Informe Actividad Clientes");
        //         // $sheet->row($i, $foot);
        //     });
        // })->download('xls');
    }

    public function reporte_profesor()
    {
        return view("records.asistencia_profesores");
    }

    public function reporte_ausentes(Request $request)
    {
        $curso = $request->curso ?? false;
        $fecha = $request->fecha ?? (new Datetime())->format("Y-m-d");
        $cursos = Record::getCursos();
        $ausentes = $curso ? Record::getAusentes($curso, $fecha, $fecha) : false;
        return view("records.reporte_ausentes", [
            "ausentes" => $ausentes,
            "cursos" => $cursos,
            "curso" => $curso,
            "fecha" => $fecha,
        ]);
    }
}
