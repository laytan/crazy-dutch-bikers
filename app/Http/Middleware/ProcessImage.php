<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Image;
use Arr;

class ProcessImage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param \Array $requestKeys
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$requestKeys)
    {
        // Validate it is an image if it is there
        $validate = [];
        foreach ($requestKeys as $key) {
            $validate[$key] = 'image';
        }
        $validated = $request->validate($validate);

        foreach ($requestKeys as $requestKey) {
            // Does the request have the key given
            if ($request->hasFile($requestKey)) {
                // Process the image
                $file = $request->file($requestKey);
                // Instantiate an Intervention Image object
                $img = Image::make($file->path());
                // Resize if needed, maintaining aspect ratio and not upsizing
                $img->resize(2000, 2000, function ($constraints) {
                    $constraints->aspectRatio();
                    $constraints->upsize();
                });
                // Orientate to given EXIF orientation data
                $img->orientate();

                // Override the old image with this processed image
                $img->save($file->path(), 95, $file->extension());
            }
        }
        return $next($request);
    }
}
