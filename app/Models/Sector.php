<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sector
 *
 * @property $id
 * @property $name
 * @property $char
 * @property $type
 * @property $start
 * @property $end
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Sector extends Model
{
    
    static $rules = [
		'name' => 'required',
		'char' => 'required',
		'type' => 'required',
		'start' => 'required',
		'end' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','char','type','start','end'];



}
