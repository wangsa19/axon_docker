<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLine extends Model
{
    use HasFactory;

    protected $primaryKey = 'productLine'; //
    public $incrementing = false; //
    protected $keyType = 'string'; //

    protected $fillable = [ //
        'productLine',
        'textDescription',
        'htmlDescription',
        'image',
    ];

    /**
     * Get the products for the product line.
     */
    public function products() //
    {
        return $this->hasMany(Product::class, 'productLine', 'productLine'); //
    }
}
