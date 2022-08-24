<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProxyStudent extends Model
{
    use HasFactory;

    protected $table = "proxy_student";
    protected $fillable = ["proxy_id", "student_id", "relationship"];
}
