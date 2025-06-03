<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = ['customerNumber', 'checkNumber']; //
    public $incrementing = false; //
    protected $keyType = 'string'; // // checkNumber is varchar

    protected $fillable = [ //
        'customerNumber',
        'checkNumber',
        'paymentDate',
        'amount',
    ];

    protected $casts = [ //
        'paymentDate' => 'date',
        'amount' => 'decimal:2', //
    ];

    /**
     * Set the keys for a save update query.
     * Overrides default to handle composite primary keys.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query) //
    {
        $keys = $this->getKeyName(); //
        if (!is_array($keys)) { //
            return parent::setKeysForSaveQuery($query); //
        }

        foreach ($keys as $keyName) { //
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName)); //
        }

        return $query; //
    }

    /**
     * Get the primary key value for a save query.
     * Overrides default to handle composite primary keys.
     *
     * @param  string|null  $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null) //
    {
        if (is_null($keyName)) { //
            $keyName = $this->getKeyName(); //
        }

        if (is_array($keyName)) { //
            return $this->getAttribute($keyName[0]); //
        }

        return parent::getKeyForSaveQuery($keyName); //
    }

    /**
     * Get the customer that the payment belongs to.
     */
    public function customer() //
    {
        return $this->belongsTo(Customer::class, 'customerNumber', 'customerNumber'); //
    }
}
