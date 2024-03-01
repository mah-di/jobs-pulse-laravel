<?php

namespace App\Helpers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ImageHelper
{
    public static function save(UploadedFile $file, string $folderName, string $filename = null)
    {
        if (!$filename) {
            $filename = uuid_create() . '.' . $file->getClientOriginalExtension();
            $fileUrl = "storage/uploads/{$folderName}/{$filename}";
            $file->storeAs("uploads/{$folderName}", $filename);
        }
        else {
            $filename .= '.' . $file->getClientOriginalExtension();
            $fileUrl = "storage/{$folderName}/{$filename}";
            $file->storeAs($folderName, $filename);
        }

        return $fileUrl;
    }

    public static function delete(?string $path)
    {
        if ($path and $path !== env('DEFAULT_PROFILE_IMG') and $path !== env('DEFAULT_BLOG_COVER_IMG') and File::exists(public_path($path)))
            File::delete(public_path($path));
    }
}
