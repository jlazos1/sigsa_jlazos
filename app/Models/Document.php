<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Document
 *
 * @property $id
 * @property $type
 * @property $documentType
 * @property $number
 * @property $date
 * @property $transmitterRut
 * @property $transmitterName
 * @property $transmitterAddress
 * @property $transmitterCity
 * @property $transmitterEmail
 * @property $transmitterSale
 * @property $receiverRut
 * @property $receiverName
 * @property $receiverAddress
 * @property $receiverCity
 * @property $receiverEmail
 * @property $receiverSale
 * @property $net
 * @property $tax
 * @property $total
 * @property $origin
 * @property $destination
 * @property $created_at
 * @property $updated_at
 *
 * @property Detail[] $details
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Document extends Model
{

    static $rules = [
        'type' => 'required',
        'documentType' => 'required',
        'net' => 'required',
        'tax' => 'required',
        'total' => 'required',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'documentType',
        'number',
        'date',
        'transmitterRut',
        'transmitterName',
        'transmitterAddress',
        'transmitterCity',
        'transmitterEmail',
        'transmitterSale',
        'receiverRut',
        'receiverName',
        'receiverAddress',
        'receiverCity',
        'receiverEmail',
        'receiverSale',
        'net',
        'tax',
        'total',
        'origin',
        'destination'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany('App\Models\Detail', 'document_id', 'id');
    }

    public static function getDocument($number, $documentType, $transmitterRut)
    {
        $document = Document::where("number", $number)
            ->where("transmitterRut", $transmitterRut)
            ->where("documentType", $documentType)
            ->first();

        return $document;
    }
}
