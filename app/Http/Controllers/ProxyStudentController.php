<?php

namespace App\Http\Controllers;

use App\Models\ProxyStudent;
use Illuminate\Http\Request;

class ProxyStudentController extends Controller
{
    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            "proxy_id" => "required",
            "student_id" => "required",
            "relationship" => "required",
        ]);

        $p = new ProxyStudent();
        $p->proxy_id = $request->proxy_id;
        $p->student_id = $request->student_id;
        $p->relationship = $request->relationship;
        $p->save();

        return redirect()->back();
    }
}
