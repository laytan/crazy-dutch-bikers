<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateGalleryRequest;
use App\Gallery;
use App\Picture;

class GalleryController extends Controller
{
    public function show(Gallery $gallery) {
        return view('galleries.show', compact('gallery'));
    }

    public function create() {
        // Remove unsupported images.* request validation for client-side validation
        $req = new CreateGalleryRequest();
        $rules = $req->rules();
        unset($rules['images.*']);

        return view('galleries.create', compact('rules'));
    }

    public function store(CreateGalleryRequest $request) {
        $validated = $request->validated();

        // Create the gallery
        $gallery             = new Gallery();
        $gallery->title      = $validated['title'];
        $gallery->is_private = isset($validated['is_private']) ? $validated['is_private'] : false;
        $gallery->save();

        // Add the images
        foreach($validated['images'] as $image) {
            // dd($image);
            $pictureUrl = $image->store("galleries/$gallery->title", ['disk' => 'public']);
            $picture             = new Picture();
            $picture->gallery_id = $gallery->id;
            $picture->url        = $pictureUrl;
            $picture->save();
        }

        return redirect()->route('galleries.index')->with('success', 'Gallerij aangemaakt');
    }
}
