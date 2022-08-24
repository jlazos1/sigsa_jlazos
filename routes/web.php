<?php

use App\Http\Controllers\ActiveController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProxyController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProductTypeController;
use App\Models\Active;
use App\Models\Detail;
use App\Models\Document;
use App\Models\Loan;
use App\Models\Nomina;
use App\Models\Permission;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Provider;
use App\Models\Proxy;
use App\Models\ProxyStudent;
use App\Models\Record;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// Instalacion
// Route::get("/install", function () {
//     Artisan::call("migrate:fresh");
//     Artisan::call("db:seed");
//     Artisan::call("storage:link");
//     Artisan::call("optimize");
//     return "Finalizado...";
// });

Route::get("/artisan/{command?}", function ($command = null) {
    if ($command) {
        switch ($command) {
            case 'migrate':
                echo "Ejecutando comando - php artisan migrate...<br>";
                $comando = Artisan::call("migrate");
                echo $comando;
                echo "Migracion realizada con éxito!.<br>";
                break;

            case 'storage':
                echo "Ejecutando comando - php artisan storage:link...<br>";
                Artisan::call("storage:link");
                echo "Se ha creado el enlace simbólico storage con éxito!.<br>";
                break;

                // case 'seed':
                //     echo "Ejecutando comando - php artisan db:seed...<br>";
                //     Artisan::call("db:seed");
                //     echo "Se han desplegado los datos en la BD correctamente!.<br>";
                //     break;

            case 'optimize':
                echo "Ejecutando comando - php artisan optimize...<br>";
                Artisan::call("optimize");
                echo "Se ha optimizado la página con éxito!.<br>";
                break;

            default:
                echo "<h3>Comandos de Artisan disponibles</h3>";
                echo "<ul>";
                echo "<li>migrate (php artisan migrate)</li>";
                echo "<li>storage (php artisan storage:link)</li>";
                echo "<li>seed (php artisan db:seed)</li>";
                echo "<li>optimize (php artisan Optimize)</li>";
                echo "</ul>";
                break;
        }
    } else {
        echo "<h3>Comandos de Artisan disponibles</h3>";
        echo "<ul>";
        echo "<li>Migrating (php artisan migrate)</li>";
        echo "<li>Storage (php artisan storage:link)</li>";
        echo "<li>Seeding (php artisan db:seed)</li>";
        echo "<li>Optimize (php artisan Optimize)</li>";
        echo "</ul>";
    }
});

Route::get('/repara_asistencia', function () {
    $students = Student::all();
    foreach ($students as $key => $student) {
        Record::where("student", $student->name)
            ->where("course_id", null)
            ->update([
                "course_id" => $student->enrollments->last()->course_id,
                "student_id" => $student->id,
            ]);
        echo $key . " ****** " . $student->name . "<br>";
    }
});

Route::get("/migrate_loans", function () {
    $students = Student::all();
    $product = Product::find(1);
    $details = array(
        array("product_id" => $product->id, "product_name" => $product->name, "product_price" => $product->priceBuy, "qty" => 1)
    );

    foreach ($students as $key => $student) {
        if (count($student->proxies) > 0) {
            $proxy_id = $student->proxies[0]->id;
            $student_id = $student->id;
            $user_sigsa = Auth::user()->id;
            $delivery = new DateTime("2021-03-10");
            $return = new DateTime("2021-12-10");
            Loan::store_prestamo($proxy_id, $student_id, null, $delivery, $return, null, $user_sigsa, $details);
            echo $key . " ***** " . $student->name . "<br>";
        }
    }
});

Route::get("/optimize", function () {
    Artisan::call("optimize");
    Artisan::call("view:clear");
    Artisan::call("cache:clear");
    Artisan::call("config:clear");
    Artisan::call("view:cache");
    Artisan::call("config:cache");
    return "Optimización finalizada...";
});

Route::get('/', function () {
    $principal = [
        "rut" => "53.330.417-6",
        "name" => "Colegio Saucache de Arica",
        "address" => "Flamenco 024",
        "city" => "Arica"
    ];
    session(["principal" => $principal]);
    return view('welcome');
});

Route::get("/google/{programa}", function ($programa) {
    session()->put("programa", $programa);
    return redirect("auth/google");
})->name("auth.google");

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

/*Route::get('/login/google', function () {
    return Socialite::driver('google')->redirect();
});*/


/*Route::get('/login/google/callback', function () {
    $data = Socialite::driver('google')->user();
    if (strpos($data->email, "@colegiosaucache.cl")) {
        $user = User::where("email", $data->email)->first();
        if (!isset($user)) {
            $user = new User();
            $user->name =  $data->name;
            $user->email =  $data->email;
            $user->provider =  "google";
            $user->provider_id =  $data->id;
            $user->save();
        }
        Auth::login($user, false);

        if (session("programa") == "canasta") {
            $permiso = Permission::where('user_id', $user->id)
                ->where('rol_id', 2)
                ->where('status', 1)
                ->first();
            if ($permiso != null) {
                return redirect()->route("canasta.create");
            } else {
                return redirect()->route("restringido", ["mensaje" => "Lo siento, $data->email no está autorizado para ingresar al Sistema de Canasta."]);
            }
        }

        if (session("programa") == "inventario") {
            $permiso = Permission::where('user_id', $user->id)
                ->where('rol_id', 3)
                ->where('status', 1)
                ->first();
            if ($permiso != null) {
                return redirect()->route("inventario.index");
            } else {
                return redirect()->route("restringido", ["mensaje" => "Lo siento, $data->email no está autorizado para ingresar al Sistema de Inventario."]);
            }
        }

        if (session("programa") == "prestamo") {
            $permiso = Permission::where('user_id', $user->id)
                ->where('rol_id', 4)
                ->where('status', 1)
                ->first();
            if ($permiso != null) {
                return redirect()->route("prestamo.index");
            } else {
                return redirect()->route("restringido", ["mensaje" => "Lo siento, $data->email no está autorizado para ingresar al Sistema de Prestamo."]);
            }
        }

        if (session("programa") == "asistencia") {
            $permiso = Permission::where('user_id', $user->id)
                ->where('rol_id', 1)
                ->where('status', 1)
                ->first();
            if ($permiso != null) {
                return redirect()->route("home");
            } else {
                return redirect()->route("restringido", ["mensaje" => "Lo siento, $data->email no está autorizado para ingresar al Sistema de Prestamo."]);
            }
        }

        if (session("programa") == "usuarios") {
            $permiso = Permission::where('user_id', $user->id)
                ->where('rol_id', 5)
                ->where('status', 1)
                ->first();
            if ($permiso != null) {
                return redirect()->route("usuario.index");
            } else {
                return redirect()->route("restringido", ["mensaje" => "Lo siento, $data->email no está autorizado para ingresar al Sistema de Prestamo."]);
            }
        }
    } else {
        return redirect()->route("restringido", ["mensaje" => "Lo siento, $data->email no pertenece al dominio de Colegio Saucache."]);
    }
    return redirect()->route("restringido", ["mensaje" => "Lo siento, $data->email Ud. no está autorizado(a) para ingresar al sistema"]);
});*/

Route::get('/restringido/{mensaje}', function ($mensaje) {
    return view("restringido", ["mensaje" => $mensaje]);
})->name("restringido");

Route::get("/cursoToNomina", [NominaController::class, "cursoToNomina"]);
Route::view("/elecciones", "votes.best-partner")->name("elecciones");
Route::view("/autoevaluacion", "autoevaluacion")->name("autoevaluacion");
Route::any("/elecciones/resultados", [VoteController::class, "resultados"])->name("elecciones.resultados");
// Route::get("/generaPIN", [PinController::class, "generaPIN"]);
Route::get("/enviaPIN", [PinController::class, "enviaPIN"]);

Route::group(["prefix" => "asistencia", 'middleware' => 'asistencia'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/config', [HomeController::class, 'config'])->name('config');
    Route::get("/reportes", [HomeController::class, "reportes"])->name("reportes");
    Route::get("/registros/curso", [RecordController::class, "reporte_curso"])->name("reporte.curso");
    Route::any("/registros/estudiante", [RecordController::class, "reporte_estudiante"])->name("reporte.estudiante");
    Route::any("/registros/profesor", [RecordController::class, "reporte_profesor"])->name("reporte.profesor");
    Route::any("/registros/ausentes", [RecordController::class, "reporte_ausentes"])->name("reporte.ausentes");
    Route::any("/registros/manual", [RecordController::class, "asistencia_manual"])->name("registro.manual");
    Route::get("/estudiantes", [StudentController::class, "lista"])->name("estudiante.lista");
    Route::any("/nomina/carga", [NominaController::class, "carga"])->name("nomina.carga");
    Route::get("/nomina/comparacion", [NominaController::class, "nominaComparacion"])->name("nomina.comparacion");
    Route::resources([
        "registro" => RecordController::class,
        "estudiante" => StudentController::class,
        "nomina" => NominaController::class,
    ]);
});

Route::group(["prefix" => "canasta", "middleware" => "canasta"], function () {
    Route::any("/carga", [BeneficiaryController::class, "carga"])->name("canasta.carga");
    Route::resources([
        "canasta" => BasketController::class,
    ]);
});

Route::get("/prestamos/todo", [LoanController::class, "reporte_todo"]);

Route::group(["prefix" => "prestamo", "middleware" => "prestamo"], function () {
    Route::get("/", [LoanController::class, "index"])->name("prestamo.index");
    Route::get("/config", [LoanController::class, "config"])->name("prestamo.config");
    Route::get("/reportes", [LoanController::class, "reportes"])->name("prestamo.reportes");
    Route::post("/reportes/curso", [LoanController::class, "reporte_curso"])->name("prestamo.reporte.curso");
    Route::get("/ver/{id}", [LoanController::class, "ver"])->name("prestamo.ver");
    Route::get("/funcionario/create", [LoanController::class, "create_funcionario"])->name("prestamo.create_funcionario");
    Route::get("/estudiante/create", [LoanController::class, "create_estudiante"])->name("prestamo.create_estudiante");
    Route::any("/devolucion/estudiante/{student_id?}", [LoanController::class, "devolucion_estudiante"])->name("devolucion.estudiante");
    Route::any("/devolucion/funcionario/{user_id?}", [LoanController::class, "devolucion_funcionario"])->name("devolucion.funcionario");
    Route::get("/menu/devolucion", [LoanController::class, "devolucion_menu"])->name("devolucion.menu");
    Route::post("/confirma/devolucion", [LoanController::class, "devolucion_confirma"])->name("prestamo.devolucion.confirma");
    Route::get("/imprime_comprobante/devolucion/{loan_id}", [LoanController::class, "devolucion_imprime_comprobante"])->name("devolucion.imprime.comprobante");
    Route::get("/lista", [LoanController::class, "lista"])->name("prestamo.lista");
    Route::post("/funcionario/confirma", [LoanController::class, "confirma_funcionario"])->name("confirma.funcionario");
    Route::post("/funcionario/confirmar", [LoanController::class, "confirmar_funcionario"])->name("confirmar.funcionario");
    Route::post("/estudiante/confirma", [LoanController::class, "confirma_estudiante"])->name("confirma.estudiante");
    Route::post("/estudiante/confirmar", [LoanController::class, "confirmar_estudiante"])->name("confirmar.estudiante");
    Route::any("/solucionar/{option}/{loan}", [LoanController::class, "solucionar"])->name("solucionar");
    Route::resources([
        "proxies" => ProxyController::class,
    ]);
});

Route::group(["prefix" => "inventario", "middleware" => "inventario"], function () {
    Route::view("/", "inventario")->name("inventario.index");
    Route::get("/entrada/registrar", [DocumentController::class, "document_entry"])->name("entrada.registrar");
    Route::get("/salida/registrar", [DocumentController::class, "document_exit"])->name("salida.registrar");
    Route::get("/detail/add/{documentId}", [DetailController::class, "detail_add"])->name("details.add");
    Route::post("/documents/store/entry", [DocumentController::class, "document_store_entry"])->name("documents.store.entry");
    Route::post("/documents/store/exit", [DocumentController::class, "document_store_exit"])->name("documents.store.exit");
    Route::post("/documents/details/{id}", [DocumentController::class, "document_details"])->name("documents.details");
    Route::get("/config", [InventarioController::class, "config"])->name("inventario.config");
    Route::get("/config/carga/productos", [InventarioController::class, "config_carga_productos"])->name("config.carga.productos");
    Route::get("/actives/fileUpload", [ActiveController::class, "import"])->name('importActives');
    Route::post("/actives/saveImport", [ActiveController::class, "saveImport"])->name('saveImport');
    Route::get('/actives/move/{id}', [ActiveController::class, "move"])->name('moveActives');
    Route::get('/actives/saveMove/{id}', [ActiveController::class, "saveMove"])->name('saveMove');
    Route::resources([
        "places" => PlaceController::class,
        "product_types" => ProductTypeController::class,
        "products" => ProductController::class,
        "actives" => ActiveController::class,
        "documents" => DocumentController::class,
        "details" => DetailController::class,
        "sectors" => SectorController::class,
        "providers" => ProviderController::class,
    ]);
});

Route::group(["prefix" => "users", "middleware" => "usuario"], function () {
    Route::get("/users/index", [UserController::class, "index"])->name("userIndex");
    Route::get("/users/show/{id}", [UserController::class, 'show'])->name("showUser");
    Route::get("/users/edit/{id}", [UserController::class, 'edit'])->name("editUser");
    Route::post("/users/update/{id}", [UserController::class, 'update'])->name("updateUser");
    Route::get("/users/permissions/{id}", [UserController::class, 'getPermission'])->name("permissionsUser");
    Route::post("/users/savepermissions/", [UserController::class, 'savePermissions'])->name("savePermissions");

    Route::get("/roles/index", [RoleController::class, "index"])->name("rolesIndex");
});

Route::group(["prefix" => "students", "middleware" => "estudiante"], function () {
    Route::get("/students/index", [StudentController::class, "index"])->name("studentIndex");
    Route::get("/students/create", [StudentController::class, "newCreate"])->name("studentCreate");
    Route::get("/students/store", [StudentController::class, "newStore"])->name("studentStore");
    Route::get("/students/show/{id}", [StudentController::class, 'show'])->name("showStudent");
    Route::get("/students/edit/{id}", [StudentController::class, 'edit'])->name("editStudent");
    Route::post("/students/update/{id}", [StudentController::class, 'update'])->name("updateStudent");
    Route::get("/students/filter", [StudentController::class, 'filter'])->name('filterStudents');
    
    Route::get("/students/saveImport", [StudentController::class, "fileUpload"])->name('studentsFileUpload');
    Route::post("/students/saveImport", [StudentController::class, "saveImport"])->name('studentsSaveImport');

});




// Consumo de APIs

Route::get("/getLastNumberByCurso/{curso}", function ($curso) {
    $nomina = Nomina::where("curso", $curso)->max("number");
    return $nomina + 1;
})->middleware("auth");

Route::get("/getProvider/{proveedor?}", function ($proveedor = null) {
    $proveedor = Provider::where("rut", $proveedor)->first();
    return $proveedor ?? false;
})->middleware("auth");

Route::get("/getDocument/{number}/{documentType}/{transmitterRut}", function ($number, $documentType, $transmitterRut) {
    $document = Document::where("number", $number)
        ->where("transmitterRut", $transmitterRut)
        ->where("documentType", $documentType)
        ->first();
    return $document ?? false;
})->middleware("auth");

Route::get("/getProduct/{id}", function ($id) {
    return Product::find($id) ?? false;
})->middleware("auth");

Route::get("/getProxies/{student}", function ($student) {
    return Student::find($student)->proxies ?? false;
})->middleware("auth");

Route::get("/getProxy/{run}", function ($run) {
    return Proxy::where("run", $run)->first() ?? false;
})->middleware("auth");

Route::get("/getStudent/{id}", function ($id) {
    return Student::find($id) ?? false;
})->middleware("auth");

Route::get("/getLoans/{student}", function ($student) {
    return (Student::find($student))->loans;
})->middleware("auth");

Auth::routes();
