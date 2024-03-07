<?php

namespace App\Services;

use App\Models\ImageMaster;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function saveImage(UploadedFile $file, String $module = 'default')
    {
        // Generate a unique filename
        $filename = uniqid() . '_' . $file->getClientOriginalName();

        // Store the image in the storage/app/public/images directory
        $file->storeAs(env('IMAGE_PATH') . $module, $filename);

        //save into table
        $image = new ImageMaster();
        $image->filename = $filename;
        $image->path = $module;
        $image->save();

        // Return the filename to be stored in the database or for further processing
        return $image;
    }

    public function getImage($filename)
    {
        // Get the path to the image in the storage/app/public/images directory
        $path = env('IMAGE_PATH') . $filename;

        // Check if the file exists
        if (Storage::exists($path)) {
            dd(Storage::get($path));
            return Storage::get($path);
        } else {
            return null;
        }
    }
}
