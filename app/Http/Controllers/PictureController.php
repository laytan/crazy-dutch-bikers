<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Http\Requests\CreatePictureRequest;
use App\Http\Requests\UpdatePictureRequest;
use App\Picture;
use Illuminate\Http\RedirectResponse;
use Storage;

class PictureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('store');
        $this->middleware('auth:api')->only('store');
        $this->middleware('can:manage');
    }

    /**
     * API Controller
     */
    public function store(CreatePictureRequest $request): Picture
    {
        $validated = $request->validated();

        $picture = new Picture;
        $picture->is_private = $validated['is_private'];
        $picture->gallery_id = Gallery::where('title', '=', $validated['gallery'])->firstOrFail()->id;
        $picture->uploadPicture($validated['image']);
        $picture->save();

        return $picture;
    }

    public function destroy(Picture $picture): RedirectResponse
    {
        Storage::disk('public')->delete($picture->url);
        $picture->delete();
        return redirect()
            ->route('galleries.show', ['gallery' => $picture->gallery->title])
            ->with('success', 'Foto verwijderd');
    }

    public function update(UpdatePictureRequest $request, Picture $picture): RedirectResponse
    {
        $validated = $request->validated();

        $picture->is_private = false;
        if (isset($validated['is_private'])) {
            $picture->is_private = true;
        }

        if (isset($validated['is_featured']) && !$picture->is_featured) {
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
        } else {
            $picture->is_featured = false;
        }

        $picture->save();

        return redirect()
            ->route('galleries.show', ['gallery' => $picture->gallery->title])
            ->with('success', 'Foto is bijgewerkt');
    }
}
