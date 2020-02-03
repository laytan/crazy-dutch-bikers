<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public function pictures() {
        return $this->hasMany('App\Picture');
    }
}
