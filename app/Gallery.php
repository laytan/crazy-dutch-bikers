<?php

namespace App;

use Gate;
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

    public static function allCheckPrivate()
    {
        if (Gate::allows('see-private-galleries')) {
            return Gallery::with('pictures')->orderBy('created_at', 'DESC')->get();
        } else {
            return Gallery::with(['pictures' => fn($q) => $q->where('is_private', '=', '0')])
                ->where('is_private', '=', '0')
                ->orderBy('created_at', 'DESC')
                ->get();
        }
    }

    public static function checkPrivate($galleryTitle)
    {
        if (Gate::allows('see-private-galleries')) {
            return Gallery::with('pictures')->where('title', '=', $galleryTitle)->firstOrFail();
        } else {
            return Gallery::with(['pictures' => fn($q) => $q->where('is_private', '=', '0')])
                ->where('is_private', '=', '0')
                ->where('title', '=', $galleryTitle)
                ->firstOrFail();
        }
    }

    /**
     * Get the latest $amt of galleries viewable by the user
     */
    public static function latest($amt)
    {
        if (Gate::allows('see-private-galleries')) {
            return Gallery::take($amt)->orderBy('created_at', 'DESC')->get();
        } else {
            return Gallery::with(['pictures' => fn($q) => $q->where('is_private', '=', '0')])
                ->where('is_private', '=', '0')
                ->orderBy('created_at', 'DESC')
                ->take(5)
                ->get();
        }
    }

    /**
     * Returns the latest added public gallery with more than 2 pictures and limits the pictures to 3
     */
    public static function featured()
    {
        $galleriesWithFeatured = Gallery::with(['pictures' => fn($q) => $q->where('is_featured', '=', '1')])
            ->withCount(['pictures'])
            ->where('is_private', '=', '0')
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach ($galleriesWithFeatured as $g) {
            if ($g->featuredPictures()->count() > 2) {
                return $g;
            }
        }

        return false;
    }

    public function featuredPictures()
    {
        return $this->pictures->where('is_featured', 1);
    }
}
