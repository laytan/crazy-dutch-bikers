<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Http\Requests\CreateGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use Storage;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage'])->except(['index', 'show']);
    }

    public function index()
    {
        $galleries = Gallery::allCheckPrivate();
        // Limit to 5 pictures per gallery
        $galleries = $galleries->map(fn($gallery) => $gallery->setRelation('pictures', $gallery->pictures->take(5)));
        return view('galleries.index', compact('galleries'));
    }

    public function show($galleryName)
    {
        $gallery = Gallery::checkPrivate($galleryName);
        return view('galleries.show', compact('gallery'));
    }

    public function store(CreateGalleryRequest $request)
    {
        $validated = $request->validated();

        // Create the gallery
        $gallery = new Gallery();
        $gallery->title = $validated['title'];
        $gallery->is_private = isset($validated['is_private']) ? $validated['is_private'] : false;
        $gallery->save();

        return redirect()->route('galleries.edit', ['gallery' => $gallery->title])
            ->with('success', 'Gallerij aangemaakt, voeg hier foto\'s toe!');
    }

    public function edit($gallery)
    {
        $gallery = Gallery::where('title', '=', $gallery)->firstOrFail();
        return view('galleries.edit', compact('gallery'));
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

        $gallery->save();
        return redirect()->route('galleries.index')->with('success', 'Gallerij is bijgewerkt');
    }

    public function destroy(Gallery $gallery)
    {
        // Remove all pictures
        foreach ($gallery->pictures as $picture) {
            Storage::disk('public')->delete($picture->url);
            $picture->delete();
        }

        $gallery->delete();
        return redirect()->route('galleries.index')->with('success', 'Gallerij is verwijderd');
    }
}
