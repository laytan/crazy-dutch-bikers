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
        // Resize to a max of 2000x2000 without upscaling or altering aspect ratio
        $img = Image::make($file->path());
        $img->resize(2000, 2000, function ($constraints) {
            $constraints->aspectRatio();
            $constraints->upsize();
        });
        $img->orientate();

        // Save the image
        $dest = 'galleries/' . $this->gallery->title . '/' . $file->hashName();
        Storage::disk('public')->put($dest, $img->encode(null, 95));
        $this->url = $dest;
    }
}
