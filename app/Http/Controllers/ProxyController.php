<?php

namespace App\Http\Controllers;

use App\Models\Proxy;
use App\Models\ProxyStudent;
use Illuminate\Http\Request;

class ProxyController extends Controller
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
        $request->validate([
            "run" => "required",
            "name1" => "required",
            "lastname1" => "required",
            "lastname2" => "required",
            "phone1" => "required",
        ]);

        $proxy = Proxy::where("run", $request->run)->first() ?? new Proxy();

        $proxy->run = $request->run;
        $proxy->name1 = $request->name1;
        $proxy->name2 = $request->name2;
        $proxy->lastname1 = $request->lastname1;
        $proxy->lastname2 = $request->lastname2;
        $proxy->lastname2 = $request->lastname2;
        $proxy->phone1 = $request->phone1;
        $proxy->phone2 = $request->phone2;
        $proxy->email = $request->email;
        $proxy->address = $request->address;
        $proxy->city = $request->city;
        $proxy->country = $request->country;
        $proxy->save();


        if ($request->student_id) {
            ProxyStudent::create([
                "proxy_id" => $proxy->id,
                "relationship" => $request->relationship,
                "student_id" => $request->student_id,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proxy  $proxy
     * @return \Illuminate\Http\Response
     */
    public function show(Proxy $proxy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proxy  $proxy
     * @return \Illuminate\Http\Response
     */
    public function edit(Proxy $proxy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proxy  $proxy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proxy $proxy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proxy  $proxy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proxy $proxy)
    {
        //
    }
}
