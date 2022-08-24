<?php

namespace App\Http\Controllers;

use App\Models\Nomina;
use App\Models\Student;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class NominaController extends Controller
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

        Nomina::updateOrCreate(
            [
                "run" => $request->run
            ],
            [
                "student" => $request->student,
                "curso" => $request->curso,
                "number" => $request->number,
                "matricula" => $request->matricula,
                "name1" => $request->name1,
                "name2" => $request->name2,
                "lastname1" => $request->lastname1,
                "lastname2" => $request->lastname2,
                "genre" => $request->genre,
                "birthday" => new Datetime($request->birthday),
            ]
        );

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nomina  $nomina
     * @return \Illuminate\Http\Response
     */
    public function show(Nomina $nomina)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nomina  $nomina
     * @return \Illuminate\Http\Response
     */
    public function edit(Nomina $nomina)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nomina  $nomina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nomina $nomina)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nomina  $nomina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nomina $nomina)
    {
        //
    }

    public function carga(Request $request)
    {
        $success = 0;
        $error = 0;
        if ($request->has("excel")) {
            try {
                $excel = IOFactory::load($request->excel);
                $hojas = $excel->getSheetNames();
                foreach ($hojas as $hoja) {
                    $sheet = $excel->getSheetByName($hoja);
                    if (Nomina::isNomina($sheet)) {
                        $i = 7;
                        while ($sheet->getCellByColumnAndRow(2, $i) != "") {
                            $name1 = trim(str_replace("  ", " ", $sheet->getCellByColumnAndRow(5, $i)));
                            $name2 = trim(str_replace("  ", " ", $sheet->getCellByColumnAndRow(6, $i)));
                            $lastname1 = trim(str_replace("  ", " ", $sheet->getCellByColumnAndRow(3, $i)));
                            $lastname2 = trim(str_replace("  ", " ", $sheet->getCellByColumnAndRow(4, $i)));
                            $student = str_replace("  ", " ", trim($name1) . " " . trim($name2) . " " . trim($lastname1) . " " . trim($lastname2));
                            $number = trim($sheet->getCellByColumnAndRow(1, $i)->getCalculatedValue());
                            $run = trim($sheet->getCellByColumnAndRow(7, $i));
                            $matricula = trim($sheet->getCellByColumnAndRow(2, $i));
                            $genre = trim($sheet->getCellByColumnAndRow(8, $i));
                            $birthday = Date::excelToDateTimeObject(trim($sheet->getCellByColumnAndRow(9, $i)->getValue()));
                            $obs = trim($sheet->getCellByColumnAndRow(10, $i));

                            Nomina::updateOrCreate(['run' =>  $run], [
                                "curso" => $hoja,
                                "number" => $number,
                                "student" => str_replace("'", "", str_replace("Ñ", "N", $student)),
                                "name1" => $name1,
                                "name2" => $name2,
                                "lastname1" => $lastname1,
                                "lastname2" => $lastname2,
                                "matricula" => $matricula,
                                "genre" => $genre,
                                "birthday" => $birthday,
                                "obs" => $obs,
                            ]);

                            $i++;
                            $success++;
                        }
                    }
                }
            } catch (Exception $e) {
                $error = "Se ha producido un error en : Curso $hoja - Lista $number - RUN $run, verifique esta línea completa, corrija y reintente";
                return view("nominas.carga", [
                    "error" => $error
                ]);
            }
        }

        return view("nominas.carga", [
            "success" => $success
        ]);
    }

    public function cursoToNomina()
    {
        $students = Student::all();
        foreach ($students as $student) {
            $object = Nomina::where("student", $student->name)->first();
            if ($object) {
                $object->curso = $student->departament ?? "SIN CURSO";
                $object->save();
            } else {
                echo $student->name . ", No se encuentra en la nómina<br>";
            }
        }
    }

    public function nominaComparacion()
    {
        $lista = array();
        $lastInserted = Student::where("type", "ESTUDIANTE")->max("created_at");
        $students = Student::where("type", "ESTUDIANTE")
            ->where("departament", "like", "BASICA%")
            ->orWhere("departament", "like", "MEDIA%")
            ->orWhere("departament", "like", "KINDER%")
            ->orWhere("departament", "like", "PREKINDER%")
            ->orderBy("departament", "ASC")
            ->get();

        foreach ($students as $student) {
            $object = Nomina::where("student", $student->name)->first();
            if (!$object) {
                array_push($lista, $student);
            }
        }

        return view("nominas.comparacion", [
            "lista" => $lista,
            "lastInserted" => $lastInserted
        ]);
    }
}
