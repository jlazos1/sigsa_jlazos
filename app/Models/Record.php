<?php

namespace App\Models;

use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Record extends Model
{
    use HasFactory;

    protected $fillable = ["student", "fecha", "hora", "duration", "teacher", "email", "action", "time"];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public static function connectedBefore($hora)
    {
        try {
            $time = $hora;
            $hora = $hora->format("H:i");
            if ($hora < "07:45") $time = new Datetime("07:45");
            if ($hora > "08:45" and $hora <  "09:05") $time = new Datetime("09:05");
            if ($hora > "10:05" and $hora <  "10:25") $time = new Datetime("10:25");
            if ($hora > "11:25" and $hora <  "11:45") $time = new Datetime("11:45");
            if ($hora > "12:45" and $hora <  "15:00") $time = new Datetime("15:00");
        } catch (Exception $e) {
            return $hora;
        }

        return $time;
    }

    public static function storeAsistenciaFile($csv)
    {
        while (!feof($csv)) {
            $linea = explode("\t", fgets($csv));
            if (isset($linea[1])) {
                $nombre = mb_convert_encoding($linea[0], "utf-8", "utf-16");
                $student = Student::where("name", $nombre)->first() ?? null;
                $accion = mb_convert_encoding($linea[1], "utf-8", "utf-16");
                $tiempo = mb_convert_encoding($linea[2], "utf-8", "utf-16");
                $tiempo = str_replace("-", "/", $tiempo);
                if ($student) {
                    if ($nombre != 'Nombre completo' and $nombre != "") {
                        $temp = explode("/", explode(" ", $tiempo)[0]);
                        $fecha = new DateTime($temp[2] . "-" . $temp[1] . "-" . $temp[0]);
                        $hora = Record::connectedBefore(new DateTime(explode(" ", $tiempo)[1]));
                        Record::updateOrCreate([
                            "student" => $student->name,
                            "student_id" => $student->id,
                            "fecha" => $fecha,
                            "hora" => $hora
                        ], [
                            "action" => $accion,
                            "email" => $student->email ?? null,
                            "teacher" => Auth::user()->name,
                            "course_id" => $student->enrollments->last()->course_id ?? null,
                        ]);
                    }
                }
            }
        }
    }

    public static function storeResumenFile($csv)
    {
        while (!feof($csv)) {
            $linea = explode("\t", fgets($csv));
            if (isset($linea[0])) {
                $nombre = mb_convert_encoding($linea[0], "utf-8", "utf-16");
                if ($nombre != "Resumen de la reunión" and $nombre != "Número total de participantes" and $nombre != "" and $nombre != "Título de la reunión" and $nombre != "Hora de inicio de la reunión" and $nombre != "Hora de finalización de la reunión" and $nombre != "ID. de reunión" and $nombre != "" and $nombre != 'Nombre completo' and $nombre != "\n") {
                    $correo = mb_convert_encoding($linea[4], "utf-8", "utf-16");
                    $duracion = mb_convert_encoding($linea[3], "utf-8", "utf-16");
                    $tiempo = mb_convert_encoding($linea[1], "utf-8", "utf-16");
                    $tiempo = str_replace("-", "/", $tiempo);
                    $temp = explode("/", explode(" ", $tiempo)[0]);
                    $fecha = new DateTime($temp[2] . "-" . $temp[1] . "-" . $temp[0]);
                    $hora_temp = new DateTime(explode(" ", $tiempo)[1]);
                    $student = Student::where("name", $nombre)->first() ?? User::where("name", $nombre)->first();
                    $hora = Record::connectedBefore($hora_temp) ?? $hora_temp;
                    if ($student) {
                        Record::updateOrCreate([
                            "student" => $nombre,
                            "student_id" => $student->id,
                            "fecha" => $fecha,
                            "hora" => $hora
                        ], [
                            "duration" => $duracion,
                            "email" => $student->email ?? null,
                            "teacher" => Auth::user()->name,
                            "course_id" => $student->enrollments->last()->course_id ?? null,
                        ]);
                    }
                }
            }
        }
    }

    public static function isDuplicate($nombre, $fecha, $hora)
    {
        $res = Record::where("student", $nombre)
            ->where("fecha", $fecha)
            ->where("hora", $hora)
            ->get();
        if (count($res) > 0) {
            return true;
        }
        return false;
    }

    public static function getCursos()
    {
        $cursos = Student::select("departament")
            ->groupBy("departament")
            ->where("departament", "like", "%BASICA%")
            ->orWhere("departament", "like", "%MEDIA%")
            ->orWhere("departament", "like", "%KINDER%")
            ->orderBy("departament", "ASC")
            ->get();
        return $cursos;
    }

    public static function getListaCurso($curso)
    {
        return Nomina::where("curso", $curso)
            ->orderBy("number", "ASC")
            ->get();
    }

    public static function asistenciaByProfesor($desde, $hasta, $profesor, $horario)
    {
        $registros = Record::where("fecha", ">=", $desde)
            ->where("fecha", "<=", $hasta)
            ->where("student", $profesor)
            ->get();

        $inicio = new DateTime($desde);
        $fin = (new DateTime($hasta))->modify("+1 days");
        $asistencia = array();

        while ($inicio != $fin) {
            if ($inicio->format("D") == "Sat") {
                $inicio->modify("+1 days");
            }

            if ($inicio->format("D") == "Sun") {
                $inicio->modify("+1 days");
            }
            $linea = [
                "dia" => $inicio->format("Y-m-d"),
                "bloque1" => 0,
                "bloque2" => 0,
                "bloque3" => 0,
                "bloque4" => 0,
                "bloque5" => 0,
            ];
            if (count($registros) > 0) {
                if ($horario == "n2") {
                    foreach ($registros as $a) {
                        if ($inicio->format("Y-m-d") == $a->fecha and $inicio->format("D") != "Sat" and $inicio->format("D") != "Sun") {
                            if ($a->hora >= "07:45" and $a->hora <= "08:45") {
                                $linea["bloque1"] = 1;
                            }
                            if ($a->hora >= "09:05" and $a->hora <= "10:05") {
                                $linea["bloque2"] = 1;
                            }
                            if ($a->hora >= "10:25" and $a->hora <= "11:25") {
                                $linea["bloque3"] = 1;
                            }
                            if ($a->hora >= "11:45" and $a->hora <= "12:45") {
                                $linea["bloque4"] = 1;
                            }
                            if ($a->hora >= "15:00" and $a->hora <= "16:00") {
                                $linea["bloque5"] = 1;
                            }
                        }
                    }
                } else {
                    foreach ($registros as $a) {
                        if ($inicio->format("Y-m-d") == $a->fecha and $inicio->format("D") != "Sat" and $inicio->format("D") != "Sun") {
                            if ($a->hora >= "08:30" and $a->hora <= "09:30") {
                                $linea["bloque1"] = 1;
                            }
                            if ($a->hora >= "09:50" and $a->hora <= "10:50") {
                                $linea["bloque2"] = 1;
                            }
                            if ($a->hora >= "11:10" and $a->hora <= "12:10") {
                                $linea["bloque3"] = 1;
                            }
                            if ($a->hora >= "12:30" and $a->hora <= "13:30") {
                                $linea["bloque4"] = 1;
                            }
                            if ($a->hora >= "15:00" and $a->hora <= "16:00") {
                                $linea["bloque5"] = 1;
                            }
                        }
                    }
                }
            }
            array_push($asistencia, $linea);
            $inicio->modify("+1 days");
        }
        return $asistencia;
    }

    public static function asistenciaByAlumno($desde, $hasta, $student_id)
    {
        $registros = Record::where("fecha", ">=", $desde)
            ->where("fecha", "<=", $hasta)
            ->where("student_id", $student_id)
            ->get();

        $inicio = new DateTime($desde);
        $fin = (new DateTime($hasta))->modify("+1 days");
        $asistencia = array();

        while ($inicio != $fin) {
            if ($inicio->format("D") == "Sat") {
                $inicio->modify("+1 days");
            }

            if ($inicio->format("D") == "Sun") {
                $inicio->modify("+1 days");
            }

            $linea = [
                "dia" => $inicio->format("Y-m-d"),
                "bloque1" => 0,
                "bloque2" => 0,
                "bloque3" => 0,
                "bloque4" => 0,
                "bloque5" => 0,
            ];

            if (count($registros) > 0) {
                foreach ($registros as $item) {
                    if ($inicio->format("Y-m-d") == $item->fecha and $inicio->format("D") != "Sat" and $inicio->format("D") != "Sun") {
                        if ($item->hora >= "07:45" and $item->hora <= "08:45") {
                            $linea["bloque1"] = ($item->action == "PRESENCIAL") ? 2 : 1;
                        }
                        if ($item->hora >= "09:05" and $item->hora <= "10:05") {
                            $linea["bloque2"] = ($item->action == "PRESENCIAL") ? 2 : 1;
                        }
                        if ($item->hora >= "10:25" and $item->hora <= "11:25") {
                            $linea["bloque3"] = ($item->action == "PRESENCIAL") ? 2 : 1;
                        }
                        if ($item->hora >= "11:45" and $item->hora <= "12:45") {
                            $linea["bloque4"] = ($item->action == "PRESENCIAL") ? 2 : 1;
                        }
                        if ($item->hora >= "15:00" and $item->hora <= "16:00") {
                            $linea["bloque5"] = ($item->action == "PRESENCIAL") ? 2 : 1;
                        }
                    }
                }
            }
            array_push($asistencia, $linea);
            $inicio->modify("+1 days");
        }
        return $asistencia;
    }

    public static function generaAsistencia($lista, $desde, $hasta)
    {
        $asistencia_curso = array();
        foreach ($lista as $item) {
            $asistencia = Record::asistenciaByAlumno($desde, $hasta, $item->student_id);
            $linea = [
                "numero" => $item->numberList,
                "estudiante" => $item->student->name,
                "asistencia" => $asistencia
            ];
            array_push($asistencia_curso, $linea);
        }
        return $asistencia_curso;
    }

    public static function getAsistenciaByCurso($curso, $desde, $hasta)
    {
        $lista = Enrollment::getList($curso);
        $asistencia = Record::generaAsistencia($lista, $desde, $hasta);

        return $asistencia;
    }


    public static function totalesAsistencia($asistencia_curso)
    {
        $totales = array();
        $dias = array();
        foreach ($asistencia_curso[0]["asistencia"] as $item) {
            array_push($dias, $item["dia"]);
        }
        foreach ($dias as $dia) {
            $total = 0;
            foreach ($asistencia_curso as $item) {
                foreach ($item["asistencia"] as $asist) {
                    if ($dia == $asist["dia"]) {
                        $cont = $asist["bloque1"] + $asist["bloque2"] + $asist["bloque3"] + $asist["bloque4"] + $asist["bloque5"];
                        if ($cont > 0) {
                            $total++;
                        }
                    }
                }
            }
            array_push($totales, ["dia" => $dia, "total" => $total]);
        }
        return $totales;
    }

    public static function getBloqueByStudent($estudiante)
    {
        // $nivel = (Student::select("departament")->where("name", $estudiante)->first())->departament;
        // $horario = ($nivel >= "BASICA-5") ? (strpos($nivel, "INDER") ? "n1" : "n2") : "n1";
        // if ($horario == "n1") {
        //     return array(
        //         ["bloque" => 1, "inicio" => "08:30", "termino" => "09:30"],
        //         ["bloque" => 2, "inicio" => "09:50", "termino" => "10:50"],
        //         ["bloque" => 3, "inicio" => "11:10", "termino" => "12:10"],
        //         ["bloque" => 4, "inicio" => "12:30", "termino" => "13:30"],
        //         ["bloque" => 5, "inicio" => "15:00", "termino" => "16:00"],
        //     );
        // }
        // if ($horario == "n2") {
        return array(
            ["bloque" => 1, "inicio" => "07:45", "termino" => "08:45"],
            ["bloque" => 2, "inicio" => "09:05", "termino" => "10:05"],
            ["bloque" => 3, "inicio" => "10:25", "termino" => "11:25"],
            ["bloque" => 4, "inicio" => "11:45", "termino" => "12:45"],
            ["bloque" => 5, "inicio" => "15:00", "termino" => "16:00"],
        );
        // }
    }

    public static function getBloqueByHour($estudiante, $hora)
    {
        $horario = Record::getBloqueByStudent($estudiante);
        foreach ($horario as $h) {
            if ($hora >= $h["inicio"] and $hora <= $h["termino"]) {
                return $h["bloque"];
            }
        }
    }

    public static function getBloqueByNumber($bloque, $estudiante = null)
    {
        $horario = array(
            ["bloque" => 1, "inicio" => "07:45", "termino" => "08:45"],
            ["bloque" => 2, "inicio" => "09:05", "termino" => "10:05"],
            ["bloque" => 3, "inicio" => "10:25", "termino" => "11:25"],
            ["bloque" => 4, "inicio" => "11:45", "termino" => "12:45"],
            ["bloque" => 5, "inicio" => "15:00", "termino" => "16:00"],
        );

        foreach ($horario as $h) {
            if ($h["bloque"] == $bloque) {
                return $h;
            }
        }
    }

    public static function getAusentes($curso, $desde, $hasta)
    {
        $bloque1 = array();
        $bloque2 = array();
        $bloque3 = array();
        $bloque4 = array();
        $bloque5 = array();

        $asistencia = Record::getAsistenciaByCurso($curso, $desde, $hasta);

        foreach ($asistencia as $item) {
            foreach ($item["asistencia"] as $asis) {
                if ($asis["bloque1"] == 0) array_push($bloque1, $item["numero"]);
                if ($asis["bloque2"] == 0) array_push($bloque2, $item["numero"]);
                if ($asis["bloque3"] == 0) array_push($bloque3, $item["numero"]);
                if ($asis["bloque4"] == 0) array_push($bloque4, $item["numero"]);
                if ($asis["bloque5"] == 0) array_push($bloque5, $item["numero"]);
            }
        }

        return array(
            "bloque1" => $bloque1,
            "bloque2" => $bloque2,
            "bloque3" => $bloque3,
            "bloque4" => $bloque4,
            "bloque5" => $bloque5,
        );
    }

    public static function getAusentes2($asistencia)
    {
        $bloque1 = array();
        $bloque2 = array();
        $bloque3 = array();
        $bloque4 = array();
        $bloque5 = array();

        foreach ($asistencia as $item) {
            foreach ($item["asistencia"] as $asis) {
                if ($asis["bloque1"] == 0) array_push($bloque1, $item["numero"]);
                if ($asis["bloque2"] == 0) array_push($bloque2, $item["numero"]);
                if ($asis["bloque3"] == 0) array_push($bloque3, $item["numero"]);
                if ($asis["bloque4"] == 0) array_push($bloque4, $item["numero"]);
                if ($asis["bloque5"] == 0) array_push($bloque5, $item["numero"]);
            }
        }

        return array(
            "bloque1" => $bloque1,
            "bloque2" => $bloque2,
            "bloque3" => $bloque3,
            "bloque4" => $bloque4,
            "bloque5" => $bloque5,
        );
    }
}
