<?php

namespace App\Imports;

use App\Models\Active;
use App\Models\Document;
use App\Models\Place;
use App\Models\Provider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ActivesImport implements
    ToModel,
    SkipsOnError,
    SkipsOnFailure,
    WithValidation,
    WithHeadingRow
{

    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row['sala'] == "") {
            $nombre_lugar = "Lugar no definido";
        } else {
            $nombre_lugar = $row['sala'];
        }

        $lugar = Place::where('name', $nombre_lugar)->first();
        if ($lugar == null) {
            $lugar = new Place();
            $lugar->name = $nombre_lugar;
            $lugar->code = $nombre_lugar;
            $lugar->save();
        }

        if ($row['n_factura'] == "") {
            $numero_factura = 0;
        } else {
            $numero_factura = $row['n_factura'];
        }

        if ($row['rut_proveedor'] == "") {
            $rut_proveedor = "Sin Rut";
        } else {
            $rut_proveedor = $row['rut_proveedor'];
        }

        $proveedor = Provider::where('rut', $rut_proveedor)->first();
        if ($proveedor == null) {
            $proveedor = new Provider();
            $proveedor->rut = $rut_proveedor;
            $proveedor->name = "Desconocido";
            $proveedor->address = "Desconocido";
            $proveedor->city = "Desconocido";
            $proveedor->save();
        }

        $factura = Document::where('number', $numero_factura)->first();
        if ($factura == null) {
            $factura = new Document();
            $factura->number = $numero_factura;
            $factura->date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_compra']);
            $factura->type = "ENTRADA";
            $factura->documentType = "FACTURA";
            $factura->receiverRut = session("principal")["rut"];
            $factura->receiverName = session("principal")["name"];
            $factura->receiverAddress = session("principal")["address"];
            $factura->receiverCity = session("principal")["city"];
            $factura->transmitterRut = $row['rut_proveedor'];
            $factura->save();
        }

        if ($row['serial_number'] == "" || $row['serial_number'] == 'S/N' || $row['serial_number'] == 'N/A') {
            $serial_number = "Sin número de serie";
        } else {
            $serial_number = $row['serial_number'];
        }

        if ($row['item'] == "") {
            $item = "Item no definido";
        } else {
            $item = $row['item'];
        }

        if ($row['marca'] == "") {
            $marca = "Sin marca";
        } else {
            $marca = $row['marca'];
        }

        if ($row['modelo'] == "") {
            $modelo = "Sin modelo";
        } else {
            $modelo = $row['modelo'];
        }

        if ($row['departamento'] == "") {
            $departamento = "Sin definir";
        } else {
            $departamento = $row['departamento'];
        }

        $sku = $row['id_saucache'];
        $obs = $row['observaciones'] . ", " . $row['obs'];


        return new Active([
            'item' => $item,
            'sku' => $sku,
            'brand' => $marca,
            'model' => $modelo,
            'serial_number' => $serial_number,
            'observation' => $obs,
            'department' => $departamento,
            'document_id' => $factura->id,
            'place_id' => $lugar->id,

        ]);
    }

    public function rules(): array
    {
        return [
            '*.sku' => ['unique:actives,sku']
        ];
    }

    public function customValidationMessages()
    {
        return [
            'sku.unique' => 'El SKU se encuentra duplicado',
        ];
    }

    public function headingRow(): int
    {
        return 3;
    }
}
