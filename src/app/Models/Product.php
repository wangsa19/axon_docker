<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'productCode'; //
    public $incrementing = false; //
    protected $keyType = 'string'; //

    protected $fillable = [ //
        'productCode',
        'productName',
        'productLine',
        'productScale',
        'productVendor',
        'productDescription',
        'quantityInStock',
        'buyPrice',
        'MSRP',
    ];

    protected $casts = [ //
        'buyPrice' => 'decimal:2',
        'MSRP' => 'decimal:2',
    ];

    /**
     * Get the product line that the product belongs to.
     */
    public function productLine() //
    {
        return $this->belongsTo(ProductLine::class, 'productLine', 'productLine'); //
    }

    /**
     * Get the order details for the product.
     */
    public function orderDetails() //
    {
        return $this->hasMany(OrderDetail::class, 'productCode', 'productCode'); //
    }
}
