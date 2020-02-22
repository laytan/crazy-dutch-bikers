<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Picture;
use Storage;
use App\Http\Requests\CreatePictureRequest;

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
}
