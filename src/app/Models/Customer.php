<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customerNumber'; //
    public $incrementing = false; //
    protected $keyType = 'int'; //

    protected $fillable = [ //
        'customerNumber',
        'customerName',
        'contactLastName',
        'contactFirstName',
        'phone',
        'addressLine1',
        'addressLine2',
        'city',
        'state',
        'postalCode',
        'country',
        'salesRepEmployeeNumber',
        'creditLimit',
    ];

    /**
     * Get the employee that represents the customer.
     */
    public function salesRepEmployee() //
    {
        return $this->belongsTo(Employee::class, 'salesRepEmployeeNumber', 'employeeNumber'); //
    }

    /**
     * Get the orders for the customer.
     */
    public function orders() //
    {
        return $this->hasMany(Order::class, 'customerNumber', 'customerNumber'); //
    }

    /**
     * Get the payments for the customer.
     */
    public function payments() //
    {
        return $this->hasMany(Payment::class, 'customerNumber', 'customerNumber'); //
    }
}
