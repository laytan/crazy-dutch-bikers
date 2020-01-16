<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    public function orderHasProducts() {
        return $this->hasMany('App\OrderHasProduct');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function getTotal() {
        $total = 0;
        foreach($this->orderHasProducts as $ohp) {
            $product = $ohp->product;
            $total += $ohp->product->price;
        }
        return $total;
    }
}
