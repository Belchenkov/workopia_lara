<?php

namespace App\Services;



use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class FileJobServices
{
    public function uploadFile($file)
    {
        return $file?->store('logos', 'public');
    }

    public function reUploadFile($file, string $path)
    {
        Storage::delete('public/logos/' . basename($path));
        return $file->store('logos', 'public');
    }

    public function deleteFile(string $path): void
    {
        Storage::delete($path);
    }
}
