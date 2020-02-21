<?php

namespace App\Http\Controllers;

use App\Picture;
use Storage;

class PictureController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage']);
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
