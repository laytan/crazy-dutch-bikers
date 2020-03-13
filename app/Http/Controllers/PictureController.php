<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Http\Requests\CreatePictureRequest;
use App\Http\Requests\UpdatePictureRequest;
use App\Picture;
use Storage;

class PictureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('store');
        $this->middleware('auth:api')->only('store');
        $this->middleware('can:manage');
    }

    public function store(CreatePictureRequest $request)
    {
        $validated = $request->validated();

        $picture = new Picture;
        $picture->is_private = $validated['is_private'];
        $picture->gallery_id = Gallery::where('title', '=', $validated['gallery'])->firstOrFail()->id;
        $picture->uploadPicture($validated['image']);
        $picture->save();

        return $picture;
    }

    public function destroy(Picture $picture)
    {
        Storage::disk('public')->delete($picture->url);
        $picture->delete();
        return redirect()
            ->route('galleries.show', ['gallery' => $picture->gallery->title])
            ->with('success', 'Foto verwijderd');
    }

    public function update(UpdatePictureRequest $request, Picture $picture)
    {
        $validated = $request->validated();

        $picture->is_private = (isset($validated['is_private']) && $validated['is_private'] !== null)
        ? $validated['is_private'] : $picture->is_private;

        // If is_featured is set to true and there are less than 3 featured images in the gallery set is_featured to tru
        // If is_featured is set to false set it to false
        if (isset($validated['is_featured']) && $validated['is_featured'] !== null) {
            if ($validated['is_featured'] === false) {
                $picture->is_featured = false;
            } elseif ($validated['is_featured'] === true) {
                if ($picture->gallery->featuredPictures()->count() < 3) {
                    $picture->is_featured = true;
                } else {
                    return redirect()
                        ->route('galleries.show', ['gallery' => $picture->gallery->title])
                        ->with(
                            'error',
                            'Deze gallerij heeft al 3 uitgelichte foto\'s, verander eerst een foto naar niet uitgelicht'
                        );
                }
            }
        }

        $picture->save();

        return redirect()
            ->route('galleries.show', ['gallery' => $picture->gallery->title])
            ->with('success', 'Foto is bijgewerkt');
    }
}
