<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'orderNumber'; //
    public $incrementing = false; //
    protected $keyType = 'int'; //

    protected $fillable = [ //
        'orderNumber',
        'orderDate',
        'requiredDate',
        'shippedDate',
        'status',
        'comments',
        'customerNumber',
    ];

    protected $casts = [ //
        'orderDate' => 'date',
        'requiredDate' => 'date',
        'shippedDate' => 'date',
    ];

    /**
     * Get the customer that owns the order.
     */
    public function customer() //
    {
        return $this->belongsTo(Customer::class, 'customerNumber', 'customerNumber'); //
    }

    /**
     * Get the order details for the order.
     */
    public function orderDetails() //
    {
        return $this->hasMany(OrderDetail::class, 'orderNumber', 'orderNumber'); //
    }
}
