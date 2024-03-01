<?php

namespace App\Services;

use App\Models\ImageMaster;
use Illuminate\Http\UploadedFile;

class ImageService
{
    public function saveImage(UploadedFile $file,String $module='default')
    {
        // Generate a unique filename
        $filename = uniqid() . '_' . $file->getClientOriginalName();

        // Store the image in the storage/app/public/images directory
        $file->storeAs( env('IMAGE_PATH').$module, $filename);

        //save into table
        $image = new ImageMaster();
        $image->filename = $filename;
        $image->path = $module;
        $image->save();

        // Return the filename to be stored in the database or for further processing
        return $image;
    }
}
