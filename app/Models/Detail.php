<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Detail
 *
 * @property $id
 * @property $document_id
 * @property $product_id
 * @property $qty
 * @property $created_at
 * @property $updated_at
 *
 * @property Document $document
 * @property Product $product
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Detail extends Model
{

    static $rules = [
        'document_id' => 'required',
        'product_id' => 'required',
        'product_name' => 'required',
        'qty' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['document_id', 'product_id', 'qty', "loan_id", "place_id", "product_name",];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function document()
    {
        return $this->hasOne('App\Models\Document', 'id', 'document_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function place()
    {
        return $this->hasOne('App\Models\Place', 'id', 'place_id');
    }

    public static function getTotal($documentId)
    {
        $items =  Detail::where('document_id', $documentId)->get();
        $suma = 0;
        foreach ($items as $item) {
            $suma += ($item->qty * $item->price);
        }
        return $suma;
    }
}
