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
        return array_map(fn ($picture) => $this->addPicture($picture), $pictures);
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
            return Gallery::with('pictures')->get();
        } else {
            return Gallery::with(['pictures' => fn ($q) => $q->where('is_private', '=', '0')])
                ->where('is_private', '=', '0')
                ->get();
        }
    }

    public static function checkPrivate($galleryTitle)
    {
        if (Gate::allows('see-private-galleries')) {
            return Gallery::with('pictures')->where('title', '=', $galleryTitle)->firstOrFail();
        } else {
            return Gallery::with(['pictures' => fn ($q) => $q->where('is_private', '=', '0')])
                ->where('is_private', '=', '0')
                ->firstOrFail();
        }
    }

    /**
     * Get the latest $amt of galleries viewable by the user
     */
    public static function latest($amt)
    {
        if (Gate::allows('see-private-galleries')) {
            return Gallery::take($amt)->get();
        } else {
            return Gallery::with(['pictures' => fn ($q) => $q->where('is_private', '=', '0')])
                ->where('is_private', '=', '0')
                ->take(5)
                ->get();
        }
    }

    /**
     * Returns the latest added public gallery with more than 2 pictures and limits the pictures to 3
     */
    public static function featured()
    {
        // Eager load public pictures
        $publicOrderedGalleries = Gallery::with(['pictures' => fn ($q) => $q->where('is_private', '=', '0')])
            ->withCount(['pictures' => fn ($q) => $q->where('is_private', '=', '0')]) // Query picture count
            ->where('is_private', '=', '0') // Only take public galleries
            ->orderBy('created_at', 'DESC') // Order newest first
            ->get();

        $publicOrderedGalleryWithPictures = null;

        // Get the first gallery with more then 2 pictures
        foreach ($publicOrderedGalleries as $gallery) {
            if ($gallery->pictures_count > 2) {
                $publicOrderedGalleryWithPictures = $gallery;
            }
        }

        // Limit picture count to 3
        if ($publicOrderedGalleryWithPictures) {
            $publicOrderedGalleryWithPictures
                ->setRelation('pictures', $publicOrderedGalleryWithPictures->pictures->take(3));
            return $publicOrderedGalleryWithPictures;
        }
    }
}
