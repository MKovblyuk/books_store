<?php
namespace App\Factories;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CoverImageFactory
{
    private $files = []; 
    private $createdLinks = [];

    public function __construct()
    {
        $this->files = Storage::disk('public')->allFiles('seeding_files/cover_images/');    
    }

    public function create(): UploadedFile
    {
        $filePath = $this->files[array_rand($this->files)];
        return new UploadedFile(public_path('storage/' . $filePath), basename($filePath));
    }

    /**
     * @return string Path to link on image
     */
    public function createLinkToImage(): string
    {
        $filePath = Storage::disk('public')->path($this->files[array_rand($this->files)]);
        $pathToLink = uniqid('cover_image_');
        $this->createdLinks[] = $pathToLink;

        symlink($filePath, Storage::disk('preview_fragments')->path($pathToLink));

        return $pathToLink;
    }

    /**
     * Remove all created files
     */
    public function rollback(): void
    {
        Storage::disk('preview_fragments')->delete($this->createdLinks);
        $this->createdLinks = [];
    }

    private function changePermissions(): void
    {
        shell_exec('chown -R www-data:www-data storage/app/public/preview_fragments');
    }
}