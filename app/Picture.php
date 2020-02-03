<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public function gallery() {
        return $this->belongsTo('App\Gallery');
    }
}
