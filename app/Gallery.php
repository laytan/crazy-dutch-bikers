<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Gallery extends Model
{
    public function pictures()
    {
        return $this->hasMany('App\Picture');
    }

    /**
     * Add pictures to the gallery
     * @param UploadedFile[] $pictures - Pictures to add.
     */
    public function addPictures(array $pictures)
    {
        return array_map(fn($picture) => $this->addPicture($picture), $pictures);
    }

    /**
     * Add a picture to the gallery
     * @param UploadedFile $picture - Picture to add.
     */
    public function addPicture(UploadedFile $picture): Picture
    {
        $pictureUrl = $picture->store("galleries/$this->title", ['disk' => 'public']);
        $picture = new Picture();
        $picture->gallery_id = $this->id;
        $picture->url = $pictureUrl;
        $picture->save();
        return $picture;
    }

    /**
     * Turn all pictures into an array of 4 arrays of pictures
     */
    public function getPictureColumnsAttribute()
    {
        $ret = [[], [], [], []];
        foreach ($this->pictures as $index => $picture) {
            $ret[$index % 4][] = $picture;
        }
        return $ret;
    }
}
