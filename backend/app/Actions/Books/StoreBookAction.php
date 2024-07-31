<?php

namespace App\Actions\Books;

use App\Helpers\DirectoryNameGenerator;
use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;
use App\Models\V1\Books\PaperFormat;
use Illuminate\Support\Facades\DB;

class StoreBookAction 
{
    private DirectoryNameGenerator $generator;

    public function __construct(DirectoryNameGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function execute(array $attributes): int
    {
        $generator = $this->generator;

        return DB::transaction(function () use($attributes, $generator) {

            $book = Book::create($attributes);
            $book->authors()->saveMany(Author::find($attributes['authors_ids']));

            $path = $generator->generate($book->id, $book->name);

            if (isset($attributes['formats']['paper'])) {
                $book->paperFormat()->save(new PaperFormat($attributes['formats']['paper']));
            }
            if (isset($attributes['formats']['audio'])) {
                $attributes['formats']['audio']['path'] = $path;
                $book->audioFormat()->save(new AudioFormat($attributes['formats']['audio']));
            }
            if (isset($attributes['formats']['electronic'])) {
                $attributes['formats']['electronic']['path'] = $path;
                $book->electronicFormat()->save(new ElectronicFormat($attributes['formats']['electronic']));
            }

            return $book->id;
        });
    }
}