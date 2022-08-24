<?php

namespace App\Http\Controllers;

use App\Models\Active;
use App\Models\Course;
use App\Models\Detail;
use App\Models\Enrollment;
use App\Models\Loan;
use App\Models\Place;
use App\Models\Product;
use App\Models\ProxyStudent;
use App\Models\Student;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::all();
        return view("loan.index", [
            "loans" => $loans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("loan.create");
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
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }

    public function config()
    {
    }

    public function ver($id)
    {
        $loan = Loan::find($id);
        if ($loan->student_id) {

            $loan = DB::table('details')
                ->join('loans', 'loans.id', '=', 'details.loan_id')
                ->join('actives', 'actives.id', '=', 'details.active_id')
                ->join('proxies', 'loans.proxy_id', '=', 'proxies.id')
                ->join('students', 'loans.student_id', '=', 'students.id')
                ->select(
                    'details.qty',
                    'details.price',
                    'loans.*',
                    'actives.item',
                    'actives.brand',
                    'actives.model',
                    'proxies.name1 AS proxy_name',
                    'proxies.lastname1 AS proxy_lastname1',
                    'proxies.lastname2 AS proxy_lastname2',
                    'students.name AS student_name',
                    'students.lastname1 AS student_lastname1',
                    'students.lastname2 AS student_lastname2',
                )
                ->where('loans.id', $id)
                ->first();
            $curso = DB::table('courses')
                ->join('enrollments', 'courses.id', '=', 'enrollments.course_id')
                ->where('enrollments.student_id', $loan->student_id)->first()->name;

            return view("loan.show", compact("loan", "curso"));
        } else {
            $loan = DB::table('details')
                ->join('loans', 'loans.id', '=', 'details.loan_id')
                ->join('actives', 'actives.id', '=', 'details.active_id')
                ->join('users', 'users.id', '=', 'loans.user_id')
                ->select(
                    'details.qty',
                    'details.price',
                    'loans.*',
                    'actives.item',
                    'actives.brand',
                    'actives.model',
                    'users.name AS user_name',
                    'users.email AS user_email',
                    'users.phone AS user_phone'
                )
                ->where('loans.id', $id)
                ->first();
            return view("loan.show", compact("loan"));
        }
    }

    public function solucionar($option, $loan)
    {
        $loan = Loan::find($loan);
        $archivo = base64_encode($this->genera_vista_pdf($loan->id));
        return view("loan.solucionar", [
            "loan" => $loan,
            "option" => $option,
            "archivo" => "data:application/pdf;base64,$archivo",
        ]);
    }

    public function create_funcionario()
    {
        $users = User::all();
        $disponible = Place::where('name', 'Disponible para Préstamo')->first()->id;
        $products = Active::where('place_id', $disponible)->get();
        return view("loan.create-funcionario", [
            "users" => $users,
            "products" => $products,
        ]);
    }

    public function create_estudiante()
    {
        $students = Student::all();
        $disponible = Place::where('name', 'Disponible para Préstamo')->first()->id;
        $products = Active::where('place_id', $disponible)->get();

        return view("loan.create-estudiante", [
            "students" => $students,
            "products" => $products,
        ]);
    }

    public function devolucion_menu()
    {
        return view("loan.devolucion-menu");
    }

    public function devolucion_estudiante($student_id = null)
    {
        $students = Student::all();



        $loans = null;
        if ($student_id) {
            $loans = Loan::where("student_id", $student_id)->get();
        }
        return view("loan.devolucion-estudiante", [
            "students" => $students,
            "student_id" => $student_id,
            "loans" => $loans,
        ]);
    }

    public function devolucion_funcionario($user_id = null)
    {
        $users = User::all();
        $loans = null;
        if ($user_id) {
            $loans = Loan::where("user_id", $user_id)->get();
        }
        return view("loan.devolucion-funcionario", [
            "users" => $users,
            "user_id" => $user_id,
            "loans" => $loans,
        ]);
    }

    public function lista()
    {
        $loans = Loan::all();
        return view("loan.lista", [
            "loans" => $loans,
        ]);
    }

    public function confirma_funcionario(Request $request)
    {
        if (!$request->loan_id) {
            $user_id = $request->user_id;
            $active_id = $request->product_id;
            $product_name = Active::find($active_id)->item;
            $delivery = $request->delivery;
            $return = $request->return;
            $user_sigsa = Auth::user()->id;
            $voucher = null;

            $details = array();
            $item = [
                "active_id" => $active_id,
                "item" => $product_name,
                "precio" => null,
                "qty" => 1,
            ];

            array_push($details, $item);
            Loan::store_prestamo(null, null, $user_id, $delivery, $return, $voucher, $user_sigsa, $details);
            $ocupado = Place::where('name', 'En Préstamo')->first()->id;
            $equipo = Active::find($active_id);
            $equipo->place_id = $ocupado;
            $equipo->save();
            $loan_id = session("loan_id");
        } else {
            $loan_id = $request->loan_id;
        }

        $archivo = base64_encode($this->genera_vista_pdf($loan_id));
        return view('loan.confirm-funcionario', [
            "archivo" => "data:application/pdf;base64,$archivo",
        ]);
    }

    public function confirmar_funcionario(Request $request)
    {
        $loan_id = session("loan_id") ?? $request->loan_id;
        $loan = Loan::find($loan_id);
        if ($request->hasFile("voucher")) {
            $voucher = $request->file("voucher");
            $ext = $voucher->getClientOriginalExtension();
            $filename = "voucher_firmado_" . time() . "." . $ext;
            $request->voucher->storeAs('public/vouchers', $filename);
            $loan->voucher = "/storage/vouchers/" . $filename;
        }
        $loan->confirmed = true;
        $loan->save();
        return redirect()->route('prestamo.index');
    }

    public function confirma_estudiante(Request $request)
    {
        if (!$request->loan_id) {
            $proxy_id = $request->proxy_id;
            $student_id = $request->student_id;
            $active_id = $request->product_id;
            $precio = $request->precio;
            $product = Active::find($active_id);
            $delivery = $request->delivery;
            $return = $request->return;
            $user_sigsa = Auth::user()->id;
            $voucher = null;

            $details = array();
            $item = [
                "active_id" => $active_id,
                "item" => $product->item,
                "qty" => 1,
                "precio" => $precio,
            ];
            array_push($details, $item);
            Loan::store_prestamo($proxy_id, $student_id, null, $delivery, $return, $voucher, $user_sigsa, $details);
            $ocupado = Place::where('name', 'En Préstamo')->first()->id;
            $equipo = Active::find($active_id);
            $equipo->place_id = $ocupado;
            $equipo->save();
            $loan_id = session("loan_id");
        } else {
            $loan_id = $request->loan_id;
        }

        $archivo = base64_encode($this->genera_vista_pdf($loan_id));
        return view('loan.confirm-estudiante', [
            "archivo" => "data:application/pdf;base64,$archivo",
        ]);
    }

    public function confirmar_estudiante(Request $request)
    {
        $loan_id = session("loan_id") ?? $request->loan_id;
        $loan = Loan::find($loan_id);
        if ($request->hasFile("voucher")) {
            $voucher = $request->file("voucher");
            $ext = $voucher->getClientOriginalExtension();
            $filename = "comodato_firmado_" . time() . "." . $ext;
            $request->voucher->storeAs('public/vouchers', $filename);
            $loan->voucher = "/storage/vouchers/" . $filename;
        }
        $loan->confirmed = true;
        $loan->save();
        return redirect()->route('prestamo.index');
    }

    public function genera_vista_pdf($loan_id)
    {
        $loan = Loan::find($loan_id);
        $user = $loan->user;
        $proxy = $loan->proxy;
        $student = $loan->student;
        $details = Detail::where('loan_id', $loan->id)->first();
        $active = Active::find($details->active_id);
        $desde = $loan->delivery;
        $hasta = $loan->return;
        $relationship = null;

        if ($loan->student_id) {
            $relationship = (ProxyStudent::where("proxy_id", $loan->proxy->id)
                ->where("student_id", $loan->student_id)
                ->first())->relationship;
        }

        // dd($student->enrollments->last()->course->name);

        $data = [
            'loan_id' => $loan->id,
            'user' => $user,
            'proxy' => $proxy,
            'student' => $student,
            'details' => $details,
            'desde' => $desde,
            'hasta' => $hasta,
            'relationship' => $relationship,
            'created_at' => $loan->created_at,
        ];

        $pdf = App::make('dompdf.wrapper');

        if ($loan->user_id) {
            $pdf->loadView('loan.pdf-funcionario', compact("data", "active"));
            $archivo = $pdf->download("prestamo-funcionario.pdf");
        }

        if ($loan->student_id) {
            $pdf->loadView('loan.pdf-estudiante', compact("data", "active"));
            $archivo = $pdf->download("prestamo-estudiante.pdf");
        }

        return $archivo;
    }

    public function devolucion_confirma(Request $request)
    {
        $loan_id = $request->loan_id;
        $observations = $request->observations;

        Loan::store_devolucion($loan_id, $observations);
        $disponible = Place::where('name', 'Disponible para Préstamo')->first()->id;
        $active_id = Detail::where('loan_id', $loan_id)->first()->active_id;
        $activo = Active::find($active_id);
        $activo->place_id = $disponible;
        $activo->save();
        return redirect()->route('devolucion.imprime.comprobante', [
            'loan_id' => $loan_id
        ]);
    }

    public function devolucion_imprime_comprobante($loan_id)
    {
        $loan = Loan::find($loan_id);
        if ($loan->student_id) {
            $loan = DB::table('details')
                ->join('loans', 'loans.id', '=', 'details.loan_id')
                ->join('actives', 'actives.id', '=', 'details.active_id')
                ->join('proxies', 'loans.proxy_id', '=', 'proxies.id')
                ->join('students', 'loans.student_id', '=', 'students.id')
                ->select(
                    'details.qty',
                    'details.price',
                    'loans.*',
                    'actives.item',
                    'actives.brand',
                    'actives.model',
                    'proxies.name1 AS proxy_name',
                    'proxies.lastname1 AS proxy_lastname1',
                    'proxies.lastname2 AS proxy_lastname2',
                    'proxies.phone1 AS proxy_phone1',
                    'proxies.run AS proxy_run',
                    'students.name AS student_name',
                    'students.lastname1 AS student_lastname1',
                    'students.lastname2 AS student_lastname2',
                )
                ->where('loans.id', $loan_id)
                ->first();

            $relationship = ProxyStudent::where('proxy_id', $loan->proxy_id)
                ->where('student_id', $loan->student_id)
                ->first();

            $curso = DB::table('courses')
                ->join('enrollments', 'courses.id', '=', 'enrollments.course_id')
                ->where('enrollments.student_id', $loan->student_id)->first()->name;

            if ($loan->returned) {
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('loan.pdf-comprobante-devolucion', compact("loan", "relationship", "curso"));
                $archivo = base64_encode($pdf->download("comprobante-devolucion.pdf"));

                return view('loan.comprobante-devolucion', [
                    "archivo" => "data:application/pdf;base64,$archivo",
                ]);
            }
        } else {
            $loan = DB::table('details')
                ->join('loans', 'loans.id', '=', 'details.loan_id')
                ->join('actives', 'actives.id', '=', 'details.active_id')
                ->join('users', 'users.id', '=', 'loans.user_id')
                ->select(
                    'details.qty',
                    'details.price',
                    'loans.*',
                    'actives.item',
                    'actives.brand',
                    'actives.model',
                    'users.name AS user_name',
                    'users.email AS user_email'
                )
                ->where('loans.id', $loan_id)
                ->first();
        }

        if ($loan->returned) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('loan.pdf-comprobante-devolucion', compact("loan"));
            $archivo = base64_encode($pdf->download("comprobante-devolucion.pdf"));

            return view('loan.comprobante-devolucion', [
                "archivo" => "data:application/pdf;base64,$archivo",
            ]);
        } else {
            if ($loan->student_id) {
                return redirect()->route("prestamo.devolucion-estudiante", [
                    "student_id" => $loan->student_id,
                ]);
            }

            if ($loan->user_id) {
                return redirect()->route("prestamo.devolucion-funcionario", [
                    "user_id" => $loan->user_id,
                ]);
            }
        }
    }

    public function reportes()
    {
        // $year = 2021;
        $loans = Loan::whereYear("delivery", 2021);
        $total = count($loans->get());
        $activos = count($loans->where("returned", null)->get());
        $devueltos = $total - $activos;
        $report = [
            "total" => $total,
            "activos" => $activos,
            "devueltos" => $devueltos,
        ];

        $courses = Course::all();
        return view('loan.reportes', compact('courses', "report"));
    }

    public function reporte_curso(Request $request)
    {
        $curso = $request->curso_id;
        $anio = $request->anio;

        $lista = Enrollment::where("course_id", $curso)
            ->where("year", $anio)
            ->get();
        $curso = Course::find($request->curso_id);
        return view('loan.reporte-curso', compact("lista", "curso", "anio"));
    }

    public function reporte_todo()
    {
        $year = (new Datetime())->format('Y');
        $loans = Loan::whereYear("delivery", $year);
        $total = count($loans->get());
        $activos = count($loans->where("returned", null)->get());
        $devueltos = $total - $activos;
        $report = [
            "total" => $total,
            "activos" => $activos,
            "devueltos" => $devueltos,
        ];

        $lista = Enrollment::where("year", 2021)
            ->orderBy("course_id", "ASC")
            ->get();

        return view('loan.reporte-todo', compact("lista", "report"));
    }
}
