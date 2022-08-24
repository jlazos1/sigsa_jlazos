<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    use HasFactory;

    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot("relationship");
    }

    public function getRelationship($student_id)
    {
        $proxies = Student::find($student_id)->proxies;
        foreach ($proxies as $proxy) {
            if ($proxy->id == $this->id) {
                return $proxy->pivot->relationship;
            }
        }
    }
}
