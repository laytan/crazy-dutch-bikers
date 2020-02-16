<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hafael\LaraFlake\Traits\LaraFlakeTrait;

class Order extends Model
{
    use SoftDeletes;
    use LaraFlakeTrait;

    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

    public function orderHasProducts()
    {
        return $this->hasMany('App\OrderHasProduct');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Count up all product prices in the order
     */
    public function getTotal()
    {
        return $this->orderHasProducts->reduce(fn ($carry, $item) => $carry + $item->product->price, 0);
    }
}
