<?php

namespace App\Services\Books;

use Illuminate\Support\Facades\Storage;

class AudioBookStorageService extends BookStorageService
{
    public function __construct(string $path)
    {
        parent::__construct($path, Storage::disk('audio'));
    }
}