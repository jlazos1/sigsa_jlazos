<?php

namespace App\Http\Controllers;

use App\Mail\EnviaPIN;
use App\Models\Pin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PinController extends Controller
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
     * @param  \App\Models\Pin  $pin
     * @return \Illuminate\Http\Response
     */
    public function show(Pin $pin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pin  $pin
     * @return \Illuminate\Http\Response
     */
    public function edit(Pin $pin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pin  $pin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pin $pin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pin  $pin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pin $pin)
    {
        //
    }

    public function generaPIN()
    {
        $res = Pin::generatePin();
        if ($res) {
            return "Se han generados nuevos pines de 6 dígitos para cada estudiante";
        } else {
            return "Error";
        }
    }

    public function enviaPIN()
    {
        $students = Pin::all();
        foreach ($students as $item) {
            Mail::to($item->email)->send(new EnviaPIN($item->email, $item->pin));
            echo $item->email . "<br>";
        }
        return "Terminamos...";
    }
}
