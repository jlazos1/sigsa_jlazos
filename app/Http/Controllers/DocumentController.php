<?php

namespace App\Http\Controllers;

use App\Models\Active;
use App\Models\Detail;
use App\Models\Document;
use App\Models\Provider;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DocumentController
 * @package App\Http\Controllers
 */
class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::all();

        return view('document.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $document = new Document();
        return view('document.create', compact('document'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Document::find($id);
        //$actives = Active::where('document_id', $id)->get();
        $actives = DB::table('actives')
            ->join('places', 'actives.place_id', '=', 'places.id')
            ->select('actives.*', 'places.name AS nombre_lugar')
            ->where('actives.document_id', $id)
            ->get();

        return view('document.show', compact('document', 'actives'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = Document::find($id);

        return view('document.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Document $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        request()->validate(Document::$rules);

        $document->update($request->all());

        return redirect()->route('documents.index')
            ->with('success', 'Documento actualizado correctamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $details = Detail::where("document_id", $id)->get();

        if (count($details) <= 0) {
            Document::destroy($id);
            return redirect()->route('documents.index')
                ->with('success', 'Se ha eliminado el documento correctamente');
        } else {
            return redirect()->route('documents.index')
                ->with('error', 'El documento que intenta eliminar contiene productos ingresados en inventario, necesita permisos especiales para eliminar.');
        }
    }

    public function document_entry()
    {
        return view("document.entry");
    }

    public function document_exit()
    {
        return view("document.exit");
    }

    public function document_store_entry(Request $request)
    {
        $request->validate(
            [
                "transmitterRut" => "required|exists:providers,rut",
                "documentType" => "required",
                "number" => "required|numeric",
                "date" => "required|date",
                "net" => "required|numeric",
                "tax" => "required|numeric",
                "total" => "required|numeric",
            ],
            [
                "transmitterRut.exists" => "Proveedor no Registrado",
                "transmitterRut.required" => "El RUT es obligatorio",
                "number.required" => "Este campo es obligatorio",
                "number.numeric" => "Este campo debe ser un número",
                "tax.required" => "Este campo es obligatorio",
                "net.required" => "Este campo es obligatorio",
                "total.required" => "Este campo es obligatorio",
                "tax.numeric" => "Este campo debe ser un número",
                "net.numeric" => "Este campo debe ser un número",
                "total.numeric" => "Este campo debe ser un número",
                "date.date" => "Debe ingresar una fecha válida",

            ]
        );

        $document = Document::getDocument($request->number, $request->documentType, $request->transmitterRut);

        if (!$document) {
            $transmitter = Provider::where("rut", $request->transmitterRut)->first();
            $document = new Document();
            $document->type = "ENTRADA";
            $document->gloss = $request->gloss;
            $document->documentType = $request->documentType;
            $document->transmitterRut = $transmitter->rut;
            $document->transmitterName = $transmitter->name;
            $document->transmitterAddress = $transmitter->address;
            $document->transmitterCity = $transmitter->city;
            $document->transmitterEmail = $transmitter->email;
            $document->receiverRut = session("principal")["rut"];
            $document->receiverName = session("principal")["name"];
            $document->receiverAddress = session("principal")["address"];
            $document->receiverCity = session("principal")["city"];
            // $document->receiverEmail = session("principal")["email"];
            $document->number = $request->number;
            $document->date = new DateTime($request->date);
            $document->net = $request->net;
            $document->tax = $request->tax;
            $document->total = $request->total;
            $document->save();

            if ($request->button1) {
                return redirect()->route('documents.index')
                    ->with('success', 'Documento de ENTRADA creado exitosamente');
            }
        }

        if ($request->button2) {
            return redirect()->route("details.add", ["documentId" => $document->id]);
        }
    }

    public function document_store_exit(Request $request)
    {
        $request->validate(
            [
                "receiverRut" => "required|exists:providers,rut",
                "documentType" => "required",
                "date" => "required|date",
                "net" => "required|numeric",
                "tax" => "required|numeric",
                "total" => "required|numeric",
            ],
            [
                "receiverRut.exists" => "Proveedor no Registrado",
                "receiverRut.required" => "El RUT es obligatorio",
                "tax.required" => "Este campo es obligatorio",
                "net.required" => "Este campo es obligatorio",
                "total.required" => "Este campo es obligatorio",
                "tax.numeric" => "Este campo debe ser un número",
                "net.numeric" => "Este campo debe ser un número",
                "total.numeric" => "Este campo debe ser un número",
                "date.date" => "Debe ingresar una fecha válida",

            ]
        );

        $document = Document::getDocument($request->number, $request->documentType, $request->receiverRut);

        if (!$document) {
            $receiver = Provider::where("rut", $request->receiverRut)->first();
            $document = new Document();
            $document->type = "SALIDA";
            $document->gloss = $request->gloss;
            $document->documentType = $request->documentType;

            $document->transmitterRut = session("principal")["rut"];
            $document->transmitterName = session("principal")["name"];
            $document->transmitterAddress = session("principal")["address"];
            $document->transmitterCity = session("principal")["city"];

            $document->receiverRut = $receiver->rut;
            $document->receiverName = $receiver->name;
            $document->receiverAddress = $receiver->address;
            $document->receiverCity = $receiver->city;
            $document->receiverEmail = $receiver->email;

            $document->number = $request->number;
            $document->date = new DateTime($request->date);
            $document->net = $request->net;
            $document->tax = $request->tax;
            $document->total = $request->total;
            $document->save();

            if ($request->button1) {
                return redirect()->route('documents.index')
                    ->with('success', 'Documento de SALIDA creado exitosamente');
            }
        }

        if ($request->button2) {
            return redirect()->route("details.add", ["documentId" => $document->id]);
        }
    }

    public function document_details($id)
    {
        $document = Document::find($id);

        return view('document.details', compact('document'));
    }
}
