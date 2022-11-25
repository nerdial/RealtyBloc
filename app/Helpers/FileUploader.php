<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploader
{

    public static function uploadToS3(string $url) :string
    {

        $fileName = Str::random(20);

        Storage::disk('minio')
            ->put($fileName, file_get_contents($url));

    }


}
