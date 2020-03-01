<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventApplication extends Model
{

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
