<?php

namespace App\Http\Controllers;

use App\Mail\EnviaPIN;
use App\Models\Pin;
use App\Models\Record;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VoteController extends Controller
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
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
    {
        //
    }

    public function resultados(Request $request)
    {
        $curso = $request->curso ?? false;
        $cursos = Record::getCursos();

        if (!$curso) {
            return view("votes.result", [
                "resultado" => false,
                "cursos" => $cursos,
                "curso" => $curso
            ]);
        } else {
            $result = Vote::getResultByCurso($curso);
            return view("votes.result", [
                "cursos" => $cursos,
                "curso" => $curso,
                "resultado" => $result
            ]);
        }
    }
}
