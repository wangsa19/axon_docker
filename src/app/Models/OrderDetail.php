<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'orderdetails'; //
    public $incrementing = false; //
    protected $primaryKey = ['orderNumber', 'productCode']; //

    protected $fillable = [ //
        'orderNumber',
        'productCode',
        'quantityOrdered',
        'priceEach',
        'orderLineNumber',
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
     * Get the order that the detail belongs to.
     */
    public function order() //
    {
        return $this->belongsTo(Order::class, 'orderNumber', 'orderNumber'); //
    }

    /**
     * Get the product associated with the order detail.
     */
    public function product() //
    {
        return $this->belongsTo(Product::class, 'productCode', 'productCode'); //
    }
}
