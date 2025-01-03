<?php

namespace App\Actions\Books\Electronic;

use App\Helpers\DirectoryNameGenerator;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StoreElectronicFormatAction
{
    public function __construct(
        private DirectoryNameGenerator $dirNameGenerator
    )
    {}

    /**
     * @throws InvalidArgumentException
     */
    public function execute(Book $book, array $attributes)
    {
        if ($book->electronicFormat) {
            throw new InvalidArgumentException('Electronic format already exists for this book');
        }

        DB::transaction(function () use ($book, $attributes) {
            $attributes['path'] = $this->dirNameGenerator->generate($book->id, $book->name);
            $format = $book->electronicFormat()->save(new ElectronicFormat($attributes));
            $format->getFileStorageService()->store($attributes['files']);
        });
    }
}