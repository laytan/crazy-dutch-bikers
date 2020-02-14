<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHasProduct extends Model
{
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
