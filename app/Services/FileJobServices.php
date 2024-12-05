<?php

namespace App\Services;



use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class FileJobServices
{
    public function uploadFile($file, string $folder, string $root_folder)
    {
        return $file?->store($folder, $root_folder);
    }

    public function reUploadFile($file, string $path, string $sub_folder, string $root_folder)
    {
        Storage::delete($path);
        return $file->store($sub_folder, $root_folder);
    }

    public function deleteFile(string $path): void
    {
        Storage::delete($path);
    }
}
