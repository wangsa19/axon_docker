<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $primaryKey = 'officeCode'; //
    public $incrementing = false; //
    protected $keyType = 'string'; //

    protected $fillable = [ //
        'officeCode',
        'city',
        'phone',
        'addressLine1',
        'addressLine2',
        'state',
        'country',
        'postalCode',
        'territory',
    ];

    /**
     * Get the employees for the office.
     */
    public function employees() //
    {
        return $this->hasMany(Employee::class, 'officeCode', 'officeCode'); //
    }
}
