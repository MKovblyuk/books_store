<?php

namespace App\Actions\Books;

use App\Helpers\FileNameGenerator;
use App\Models\V1\Books\Fragment;
use Illuminate\Support\Facades\Storage;

class StoreFragmentAction
{
    private FileNameGenerator $generator;

    public function __construct()
    {
        $this->generator = new FileNameGenerator();
    }

    public function execute($bookId, $file)
    {
        $path = $this->generator->generate($bookId, 'image');
        Storage::disk('preview_fragments')->put($path, $file->getContent());

        Fragment::create([
            'book_id' => $bookId,
            'path' => $path,
        ]);
    }
}