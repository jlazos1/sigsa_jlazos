<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\Place;
use App\Models\Product;
use App\Models\Provider;
use App\Models\User;
use Livewire\Component;

class EntradaRegistroComponent extends Component
{
    public $documentType, $number, $date, $net, $tax, $total;
    public $transmitterRut, $transmitterName, $transmitterAddress, $transmitterCity, $transmitterEmail;

    public $products, $product;
    public $section1, $section2, $section3, $section4;
    public $valid_rut, $finderRut, $finderDocument, $provider;
    public $valid_documentType, $valid_number, $valid_date, $valid_net, $valid_tax, $valid_total;
    public $detailProduct, $detailPrice, $detailQty, $detailTotal, $detailPlace;
    public $places, $detailProducts = array();

    public function mount()
    {
        $this->products = Product::all();
        $this->places = Place::all();
    }

    public function render()
    {
        return view('livewire.entrada-registro-component');
    }

    public function addLine()
    {
        $product = Product::find($this->detailProduct);
        $place = Place::find($this->detailPlace);
        $detail = [
            "productId" => $product->id,
            "productName" => $product->name,
            "price" => $this->detailPrice,
            "quantity" => $this->detailQty,
            "total" => $this->detailTotal,
            "placeId" => $place->id,
            "placeName" => $place->name,
        ];

        array_push($this->detailProducts, $detail);

        $this->detailProduct = "";
        $this->detailPrice = "";
        $this->detailQty = "";
        $this->detailTotal = "";

        $this->emit("addLineFocus");
    }

    public function totalLine()
    {
        $this->detailTotal = $this->detailPrice * $this->detailQty;
    }

    public function searchProduct()
    {
        $product = Product::find($this->detailProduct);
        $this->detailPrice = $product->priceBuy;
    }

    public function calcTotal()
    {
        $this->total = $this->net + $this->tax;
    }

    public function calcTax()
    {
        $this->tax = $this->net * 0.19;
        $this->calcTotal();
    }

    public function searchEmisor()
    {
        $rut = $this->transmitterRut;
        $this->provider = Provider::where("rut", $rut)->first();
        if (isset($this->provider)) {
            $this->transmitterRut = $this->provider->rut;
            $this->transmitterName = $this->provider->name;
            $this->transmitterAddress = $this->provider->address;
            $this->transmitterCity = $this->provider->city;
            $this->transmitterEmail = $this->provider->email;
        } else {
            $this->finderRut = "Proveedor no existe en la base de datos, rellene los datos y se agregará como proveedor al presionar 'SIGUIENTE'";
        }
    }

    public function storeProvider()
    {
        $provider = new Provider();
        $provider->rut = $this->transmitterRut;
        $provider->name = $this->transmitterName;
        $provider->address = $this->transmitterAddress;
        $provider->city = $this->transmitterCity;
        $provider->email = $this->transmitterEmail;
        $provider->save();
    }

    public function repairRut()
    {
        $this->transmitterRut = preg_replace('/[^k0-9,-]/', '', $this->transmitterRut);
    }

    public function searchDocumentProvider()
    {
        $document = Document::where("documentType", $this->documentType)
            ->where("transmitterRut", $this->transmitterRut)
            ->where("number", $this->number)
            ->first();

        if (isset($document)) {
            $this->finderDocument = "ADVERTENCIA : Este documento ya existe, no se puede agregar.";
        } else {
            $this->finderDocument = "";
        }
    }

    public function validatePaso2()
    {
        $this->valid_documentType = $this->documentType == "" ? "is-invalid" : "is-valid";
        $this->valid_number = $this->number == "" ? "is-invalid" : "is-valid";
        $this->valid_date = $this->date == "" ? "is-invalid" : "is-valid";
        $this->valid_net = $this->net == "" ? "is-invalid" : "is-valid";
        $this->valid_tax = $this->tax == "" ? "is-invalid" : "is-valid";
        $this->valid_total = $this->total == "" ? "is-invalid" : "is-valid";
    }
}
