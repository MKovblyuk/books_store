<?php

namespace App\Traits;

use App\Exceptions\General\FileExistException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\FilesystemAdapter;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait FileStorage 
{
    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function downloadFile(FilesystemAdapter $fileSystem ,string $dirName, string $extension, string $name = null): StreamedResponse
    {
        $files = $fileSystem->allFiles($dirName);

        foreach ($files as $file) {
            if (\File::extension($file) === $extension) {
                return $fileSystem->download($file, $name);
            }
        }

        throw new FileNotFoundException('File not found');
    }

    /**
     * @throws \App\Exceptions\General\FileExistException
     */
    protected function storeFiles(FilesystemAdapter $fileSystem, string $dirName, array $newFiles)
    {
        foreach($newFiles as $newFile) {
            $newFileMimeType = $newFile->getMimeType();
            $files = $fileSystem->allFiles($dirName);

            foreach ($files as $file) {
                if ($fileSystem->mimeType($file) === $newFileMimeType) {
                    throw new FileExistException('File with this MIME type already exist.');
                }
            }

            $fileSystem->makeDirectory($dirName);
            $fileSystem->put($dirName, $newFile);
        }
    }
}