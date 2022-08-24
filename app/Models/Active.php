<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Active extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'place_id',
        'brand', 
        'model',
        'serial_number',
        'sku',
        'rut_provider',
        'bill_number',
        'bill_date',
        'price',
        'department',
        'observation',
        'document_id'
    ];

    protected $table = "actives";

}
