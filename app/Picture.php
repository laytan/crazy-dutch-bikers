<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public function gallery()
    {
        return $this->belongsTo('App\Gallery');
    }

    public function getDimensionsAttribute() {
        list($width, $height, $type, $attr) = getimagesize(public_path( 'storage/' . $this->url ));
        return [$width, $height];
    }
}
