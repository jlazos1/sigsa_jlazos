<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ["proxy_id", "student_id", "user_id", "delivery", "return", "voucher", "user_sigsa"];

    public function details()
    {
        return $this->hasMany(Detail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proxy()
    {
        return $this->belongsTo(Proxy::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentParent()
    {
        return $this->belongsTo(StudentParents::class);
    }

    public static function store_prestamo($proxy_id, $student_id, $user_id, $delivery, $return, $voucher, $user_sigsa, $details)
    {
        DB::transaction(function () use ($proxy_id, $student_id, $user_id, $delivery, $return, $voucher, $user_sigsa, $details) {
            $loan = Loan::create([
                "proxy_id" => $proxy_id,
                "student_id" => $student_id,
                "user_id" => $user_id,
                "user_sigsa" => $user_sigsa,
                "delivery" => $delivery,
                "return" => $return,
                "voucher" => $voucher,
            ]);

            foreach ($details as $item) {
                $detalle = new Detail();
                $detalle->loan_id = $loan->id;
                $detalle->active_id = $item['active_id'];
                $detalle->product_name = $item['item'];
                $detalle->price = $item['precio'];
                $detalle->qty = $item['qty']*-1;
                $detalle->save();

            }
            session()->flash("loan_id", $loan->id);
        });
    }

    public static function store_devolucion($loan_id, $observations)
    {
        DB::transaction(function () use ($loan_id, $observations) {
            $loan = Loan::find($loan_id);
            DB::table('loans')
                ->where('id', $loan_id)
                ->update([
                    "observations" => $loan->observations . "--- Observaciones al devolver : " . $observations,
                    "returned" => new DateTime(),
                ]);
                

            /*foreach ($loan->details as $detail) {
                Detail::create([
                    "loan_id" => $loan_id,
                    "product_id" => $detail->active_id,
                    "product_name" => $detail->product_name,
                    "price" => $detail->price,
                    "qty" => ($detail->qty * -1), // como el prestamo es salida al devolver es un ingreso, por lo tanto se multiplica por -1 para que se vuelva positiva
                ]);
            }*/
            session()->flash("loan_id", $loan->id);
        });
    }
}
