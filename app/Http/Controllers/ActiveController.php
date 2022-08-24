<?php

namespace App\Http\Controllers;

use App\Imports\ActivesImport;
use App\Models\Active;
use App\Models\Detail;
use App\Models\Document;
use App\Models\Place;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class ActiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actives = DB::table('actives')
            ->join('places', 'places.id', '=', 'actives.place_id')
            ->select('actives.*', 'places.name AS place_name')
            ->get();
        return view('actives.index', compact('actives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = new Active();
        $places = Place::all();

        return view('actives.create', compact('active', 'places'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'item' => ['required'],
            'brand' => ['required'],
            'model' => ['required'],
            'serial_number' => ['required'],
            'place_id' => ['required', 'not_in:0'],

            'bill_number' => ['required'],
            'bill_date' => ['required'],
            'rut_provider' => ['required'],
        ], [
            'item.required' => 'Ingrese el nombre del producto',
            'brand.required' => 'Ingrese la marca del producto',
            'model.required' => 'Ingrese el modelo del producto',
            'serial_number.required' => 'Ingrese el código de serie del producto',
            'place_id.required' => 'Selecione un lugar de almacenado',
            'place_id.not_in' => 'Selecione un lugar de almacenado',


            'bill_number.required' => 'Ingrese el número de factura',
            'bill_date.required' => 'Ingrese la fecha de la factura',
            'rut_provider.required' => 'Ingrese el RUT del Proveedor',
        ]);

        $findDocument = Document::where('transmitterRut', $request->input('rut_provider'))
            ->where('number', $request->input('bill_number'))
            ->first();

        $sku = intval(DB::table('actives')->orderByDesc('id')->first()->sku) + 1;


        if ($findDocument == null) {
            $document = new Document();
            $document->documentType = "FACTURA";
            $document->type = "ENTRADA";
            $document->number = $request->input('bill_number');
            $document->date = $request->input('bill_date');
            $document->receiverRut = session("principal")["rut"];
            $document->receiverName = session("principal")["name"];
            $document->receiverAddress = session("principal")["address"];
            $document->receiverCity = session("principal")["city"];
            $document->transmitterRut = $request->input('rut_provider');
            $document->save();

            $active = new Active();
            $active->item = $request->input('item');
            $active->brand = $request->input('brand');
            $active->model = $request->input('model');
            $active->department = $request->input('department');
            $active->serial_number = $request->input('serial_number');
            $active->observation = $request->input('observation');
            $active->document_id = $document->id;
            $active->place_id = $request->input('place_id');
            $active->save();
        } else {
            $active = new Active();
            $active->item = $request->input('item');
            $active->brand = $request->input('brand');
            $active->model = $request->input('model');
            $active->department = $request->input('department');
            $active->serial_number = $request->input('serial_number');
            $active->observation = $request->input('observation');
            $active->place_id = $request->input('place_id');
            $active->document_id = $findDocument->id;
            $active->save();
        }

        $active->sku = "0" . $sku;
        $active->save();


        return redirect()->route('actives.index')
            ->with('success', 'Activo creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Active  $active
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $active = Active::find($id);
        $nombre_lugar = Place::where('id', $active->place_id)->first()->name;

        return view('actives.show', compact('active', 'nombre_lugar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Active  $active
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $active = Active::find($id);
        $bill = Document::find($active->document_id);
        $places = Place::all();

        return view('actives.edit', compact('active', 'places', 'bill'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Active  $active
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Active $active)
    {
        $request->validate([
            'item' => ['required'],
            'brand' => ['required'],
            'model' => ['required'],
            'serial_number' => ['required'],
            'place_id' => ['required', 'not_in:0'],

            'bill_number' => ['required'],
            'bill_date' => ['required'],
            'rut_provider' => ['required'],
        ], [
            'item.required' => 'Ingrese el nombre del producto',
            'brand.required' => 'Ingrese la marca del producto',
            'model.required' => 'Ingrese el modelo del producto',
            'serial_number.required' => 'Ingrese el código de serie del producto',
            'serial_number.unique' => 'Este número de serie ya fue ingresado',
            'place_id.required' => 'Selecione un lugar de almacenamiento',
            'place_id.not_in' => 'Selecione un lugar de almacenamiento',


            'bill_number.required' => 'Ingrese el número de factura',
            'bill_date.required' => 'Ingrese la fecha de la factura',
            'rut_provider.required' => 'Ingrese el RUT del Proveedor',
        ]);

        $findDocument = Document::where('transmitterRut', $request->input('rut_provider'))
            ->where('number', $request->input('bill_number'))
            ->first();

        if ($findDocument == null) {
            $document = new Document();
            $document->documentType = "FACTURA";
            $document->type = "ENTRADA";
            $document->number = $request->input('bill_number');
            $document->date = $request->input('bill_date');
            $document->receiverRut = session("principal")["rut"];
            $document->receiverName = session("principal")["name"];
            $document->receiverAddress = session("principal")["address"];
            $document->receiverCity = session("principal")["city"];
            $document->transmitterRut = $request->input('rut_provider');
            $document->save();

            $active->item = $request->input('item');
            $active->brand = $request->input('brand');
            $active->model = $request->input('model');
            $active->department = $request->input('department');
            $active->serial_number = $request->input('serial_number');
            $active->observation = $request->input('observation');
            $active->document_id = $document->id;
            $active->place_id = $request->input('place_id');
            $active->save();
        } else {
            $active->item = $request->input('item');
            $active->brand = $request->input('brand');
            $active->model = $request->input('model');
            $active->department = $request->input('department');
            $active->serial_number = $request->input('serial_number');
            $active->observation = $request->input('observation');
            $active->place_id = $request->input('place_id');
            $active->document_id = $findDocument->id;
            $active->save();
        }

        return redirect()->route('actives.index')
            ->with('success', 'Activo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Active  $active
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Active::find($id)->delete();

        return redirect()->route('actives.index')
            ->with('success', 'Activo eliminado correctamente');
    }

    public function import()
    {
        return view('actives.fileUpload');
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
        $import = new ActivesImport;
        $import->import($file);
        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }
        
        return redirect()->route('importActives')
            ->with('status', 'Activos importados correctamente');
    }

    public function move($id)
    {
        $active = Active::find($id);
        $nombre_lugar = Place::where('id', $active->place_id)->first()->name;
        $places = Place::all();

        return view('actives.move', compact('active', 'nombre_lugar', 'places'));
    }

    public function saveMove(Request $request, $id)
    {
        $request->validate([
            'place_id' => ['required'],
        ], [
            'place_id.required' => "Seleccione un lugar",
        ]);
        $active = Active::find($id);

        $active->place_id = $request->input('place_id');
        $active->save();

        return redirect()->route('actives.index')
            ->with('success', 'Activo movido correctamente');
    }
}
