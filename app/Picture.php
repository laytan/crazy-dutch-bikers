<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Image;
use Storage;

class Picture extends Model
{
    public function gallery()
    {
        return $this->belongsTo('App\Gallery');
    }

    public function getDimensionsAttribute()
    {
        list($width, $height, $type, $attr) = getimagesize(storage_path('app/public/' . $this->url));
        return [$width, $height];
    }

    public function uploadPicture(UploadedFile $file)
    {
        $this->url = $file->store('galleries', ['disk' => 'public']);
    }
}
