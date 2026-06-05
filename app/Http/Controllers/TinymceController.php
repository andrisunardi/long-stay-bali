<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use Intervention\Image\Facades\Image;

class TinymceController extends Controller
{
    public function uploadImage(UploadImageRequest $request)
    {
        $directory = 'images/guide';
        $baseUrl = request()->getSchemeAndHttpHost();

        $assetPath = config('constants.assets.path').'/'.$directory;
        $assetUrl = config('constants.assets.url');

        $fullUrl = "{$baseUrl}{$assetUrl}";

        $image = Image::make($request->file('file'));

        // $image->resize(1200, null, function ($constraint) {
        //     $constraint->aspectRatio();
        //     $constraint->upsize();
        // });

        $fileName = 'tinymce-'.now()->format('Y-m-d-H-i-s').'.webp';
        $fullPath = "{$assetPath}/{$fileName}";

        $encoded = (string) $image->encode('webp', 70);

        file_put_contents($fullPath, $encoded);

        return response()->json([
            'location' => "{$fullUrl}/{$directory}/{$fileName}",
        ]);
    }
}
