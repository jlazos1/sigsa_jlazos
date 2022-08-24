<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    use HasFactory;

    protected $fillable = [
        "email", "pin"
    ];

    public static function generatePin()
    {
        try {
            $students = Student::all();
            foreach ($students as $item) {
                $pin = rand(100000, 999999);
                Pin::create([
                    "email" => $item->email,
                    "pin" => $pin,
                ]);
            }
            return true;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }
}
