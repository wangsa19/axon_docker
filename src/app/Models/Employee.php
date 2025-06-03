<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employeeNumber'; //
    public $incrementing = false; //
    protected $keyType = 'int'; //

    protected $fillable = [ //
        'employeeNumber',
        'lastName',
        'firstName',
        'extension',
        'email',
        'officeCode',
        'reportsTo',
        'jobTitle',
    ];

    /**
     * Get the office that the employee works in.
     */
    public function office() //
    {
        return $this->belongsTo(Office::class, 'officeCode', 'officeCode'); //
    }

    /**
     * Get the manager that the employee reports to.
     */
    public function manager() //
    {
        return $this->belongsTo(Employee::class, 'reportsTo', 'employeeNumber'); //
    }

    /**
     * Get the direct reports for the employee.
     */
    public function reports() //
    {
        return $this->hasMany(Employee::class, 'reportsTo', 'employeeNumber'); //
    }

    /**
     * Get the customers that this employee is a sales representative for.
     */
    public function customers() //
    {
        return $this->hasMany(Customer::class, 'salesRepEmployeeNumber', 'employeeNumber'); //
    }
}
