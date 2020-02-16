<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Gallery;
use App\Picture;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:access-image,picture')->only('picture');
        $this->middleware('can:manage')->except(['index', 'show', 'picture']);
    }

    public function index()
    {
        $galleries = Gallery::with('pictures')->get();
        return view('galleries.index', compact('galleries'));
    }

    public function show($galleryName)
    {
        $gallery = Gallery::where('title', '=', $galleryName)->firstOrFail();
        $updateRequest = new UpdateGalleryRequest();
        $updateRequest = $updateRequest->rules();
        unset($updateRequest['images.*']);
        unset($updateRequest['images']);
        return view('galleries.show', compact('gallery', 'updateRequest'));
    }

    public function create()
    {
        // Remove unsupported images.* request validation for client-side validation
        $req = new CreateGalleryRequest();
        $rules = $req->rules();
        unset($rules['images.*']);

        return view('galleries.create', compact('rules'));
    }

    public function store(CreateGalleryRequest $request)
    {
        $validated = $request->validated();

        // Create the gallery
        $gallery             = new Gallery();
        $gallery->title      = $validated['title'];
        $gallery->is_private = isset($validated['is_private']) ? $validated['is_private'] : false;
        $gallery->save();

        // Add the images
        foreach ($validated['images'] as $image) {
            // dd($image);
            $pictureUrl = $image->store("galleries/$gallery->title", ['disk' => 'private']);
            $picture             = new Picture();
            $picture->gallery_id = $gallery->id;
            $picture->url        = $pictureUrl;
            $picture->save();
        }

        return redirect()->route('galleries.index')->with('success', 'Gallerij aangemaakt');
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $validatedData = $request->validated();

        if (isset($validatedData['title'])) {
            $gallery->title = $validatedData['title'];
        }

        if (isset($validatedData['is_private'])) {
            $gallery->is_private = true;
        } else {
            $gallery->is_private = false;
        }

        debug('TODO: handle adding pictures');

        $gallery->save();
        return redirect()->route('galleries.index')->with('success', 'Gallerij is bijgewerkt');
    }

    public function destroy(Gallery $gallery)
    {
        // Remove all pictures
        foreach ($gallery->pictures as $picture) {
            Storage::disk('private')->delete($picture->url);
            $picture->delete();
        }

        $gallery->delete();
    }

    public function picture($gallery, Picture $picture)
    {
        $path = "app/private/$picture->url";
        return file_response($path);
    }
}
