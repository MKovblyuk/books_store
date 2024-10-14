<?php

namespace App\Actions\Books;

use App\Helpers\FileNameGenerator;
use App\Models\V1\Books\Book;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateBookCoverImageAction
{
    private FileNameGenerator $generator;

    public function __construct(FileNameGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function execute(Book $book, UploadedFile $image)
    {
        if ($book->cover_image_path) {
            Storage::disk('preview_fragments')->delete($book->cover_image_path);
        }
        
        $path = $this->generator->generate($book->id, 'cover_image');

        if (!Storage::disk('preview_fragments')->put($path, $image->get())) {
            throw new Exception('File not written');
        }

        $book->update(['cover_image_path' => $path]);
    }
}