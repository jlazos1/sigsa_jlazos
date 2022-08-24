<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vote extends Model
{
    use HasFactory;

    public static function getResultByCurso($curso)
    {
        $result = DB::select(DB::raw("select a.candidate, count(a.candidate) votos, b.name, b.email, b.departament
        from votes a
        inner join students b
        on a.candidate=b.email
        where b.departament='$curso'
        group by a.candidate
        order by votos DESC"));

        return $result;
    }
}
