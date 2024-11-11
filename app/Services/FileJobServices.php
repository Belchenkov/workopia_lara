<?php

namespace App\Services;



use Symfony\Component\HttpFoundation\File\File;

class FileJobServices
{
    public function uploadFile($file)
    {
        return $file?->store('logos', 'public');
    }
}
