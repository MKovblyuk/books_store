<?php

namespace App\Services\Books;

use App\Traits\FileStorage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\FilesystemAdapter;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookStorageService implements BookStorageServiceInterface
{
    use FileStorage;

    public function __construct(
        private string $path,
        private FilesystemAdapter $fileSystem
    )
    {}

    public function store(array $files)
    {
        $this->storeFiles($this->fileSystem, $this->path, $files);
    }

    public function download(string $extension, string $name = null): StreamedResponse
    {
        return $this->downloadFile($this->fileSystem, $this->path, $extension, $name);
    }

    public function delete(): bool
    {
        return $this->deleteAllFiles($this->fileSystem, $this->path);
    }

    public function deleteFile(string $extension): bool
    {
        $files = $this->fileSystem->allFiles($this->path);

        foreach ($files as $file) {
            if (\File::extension($file) === $extension) {
                return $this->fileSystem->delete($file);
            }
        }

        throw new FileNotFoundException('File not found');
    }

    /**
     * Return files meta
     */
    public function getAllFiles(): array
    {
        return $this->getAllFilesMeta($this->fileSystem, $this->path);
    }
}