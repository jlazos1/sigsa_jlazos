<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'number_list',
        'student_id',
        'numberRecord',
        'year'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public static function getList($course)
    {
        $course_id = (Course::where("name", $course)->orWhere("id", $course)->first())->id;
        $list = Enrollment::where("course_id", $course_id)
            ->orderBy("numberList", "ASC")->get();
        return $list;
    }
}
