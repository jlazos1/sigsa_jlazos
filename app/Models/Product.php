<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property $id
 * @property $name
 * @property $description
 * @property $model
 * @property $sku
 * @property $code
 * @property $brand
 * @property $priceBuy
 * @property $priceSale
 * @property $created_at
 * @property $updated_at
 *
 * @property Detail[] $details
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Product extends Model
{

    static $rules = [
        'name' => ['required'],
        'description' => ['required'],
        'product_type_id' => ['required'],
        'brand' => ['required'],
        'model' => ['required'],
        'code' => ['required'],
        'sku' => ['required','unique:products']
    ];

    
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'model', 'sku', 'code', 'brand', 'priceBuy', 'priceSale', 'product_type_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany('App\Models\Detail', 'product_id', 'id');
    }
}
