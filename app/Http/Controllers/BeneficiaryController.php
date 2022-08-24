<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Nomina;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BeneficiaryController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function show(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function edit(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beneficiary $beneficiary)
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
                $studentRun = "Inicio";
                foreach ($hojas as $hoja) {
                    $sheet = $excel->getSheetByName($hoja);
                    if (Beneficiary::recognizeFile($sheet)) {
                        $i = 4;
                        while ($sheet->getCellByColumnAndRow(1, $i) != "") {
                            $studentRun = $sheet->getCellByColumnAndRow(2, $i);
                            $student = Student::getByRun($studentRun);
                            $asignado = Date::excelToDateTimeObject(trim($sheet->getCellByColumnAndRow(3, $i)->getValue()));
                            if ($student) {
                                Beneficiary::create([
                                    "studentRun" => $studentRun,
                                    "studentName" => $student->name,
                                    "studentEmail" => $student->email,
                                    "curso" => $student->departament,
                                    "asignado" => $asignado,
                                ]);
                            } else {
                                echo "<br>No se puede cargar $studentRun";
                            }

                            $i++;
                            $success++;
                        }
                    } else {
                        return "Archivo invalido";
                    }
                }
            } catch (Exception $e) {
                $error = "Se ha producido un error en : $studentRun,  verifique esta línea completa, corrija y reintente";
                echo $error . "<br>";
                // return view("beneficiary.carga", [
                //     "error" => $error
                // ]);
            }
        } else {
            return view("beneficiary.carga", [
                "success" => $success,
            ]);
        }
    }
}
