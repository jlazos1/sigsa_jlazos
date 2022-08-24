<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaceTypeRequest;
use App\Http\Requests\UpdatePlaceTypeRequest;
use App\Models\PlaceType;

class PlaceTypeController extends Controller
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
     * @param  \App\Http\Requests\StorePlaceTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlaceTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlaceType  $placeType
     * @return \Illuminate\Http\Response
     */
    public function show(PlaceType $placeType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlaceType  $placeType
     * @return \Illuminate\Http\Response
     */
    public function edit(PlaceType $placeType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlaceTypeRequest  $request
     * @param  \App\Models\PlaceType  $placeType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlaceTypeRequest $request, PlaceType $placeType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlaceType  $placeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlaceType $placeType)
    {
        //
    }
}
