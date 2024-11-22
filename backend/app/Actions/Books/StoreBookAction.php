<?php

namespace App\Actions\Books;

use App\Helpers\DirectoryNameGenerator;
use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;
use App\Models\V1\Books\PaperFormat;
use Exception;
use Illuminate\Support\Facades\DB;

class StoreBookAction 
{
    public function __construct(
        private DirectoryNameGenerator $dirNamegenerator,
        private UpdateBookCoverImageAction $updateBookCoverImageAction,
        private DeleteBookCoverImageAction $deleteBookCoverImageAction
    ){}

    public function execute(array $attributes): int
    {
        return DB::transaction(function () use($attributes) {
            $book = Book::create($attributes);
            $book->authors()->saveMany(Author::find($attributes['authors_ids']));
            $path = $this->dirNamegenerator->generate($book->id, $book->name);

            try {
                $this->storePaperFormat($book, $attributes);
                $this->storeElectronicFormat($book, $path, $attributes);
                $this->storeAudioFormat($book, $path, $attributes);
                $this->storeCoverImage($book, $attributes);

                return $book->id;
            } catch (Exception $e) {
                if (isset($attributes['formats']['audio'])) {
                    $book->audioFormat->getFileStorageService()->delete($book);
                }
                if (isset($attributes['formats']['electronic'])) {
                    $book->electronicFormat->getFileStorageService()->delete($book);
                }
                if (isset($attributes['cover_image'])) {
                    $this->deleteBookCoverImageAction->execute($book);
                }

                throw $e;
            }
        });
    }

    private function storeElectronicFormat(Book $book, string $path, array $attributes): void
    {
        if (isset($attributes['formats']['electronic'])) {
            $attributes['formats']['electronic']['path'] = $path;
            $book->electronicFormat()->save(new ElectronicFormat($attributes['formats']['electronic']));
            $book->electronicFormat->getFileStorageService()->store($attributes['formats']['electronic']['files']);
        }
    }

    private function storeAudioFormat(Book $book, string $path, array $attributes): void
    {
        if (isset($attributes['formats']['audio'])) {
            $attributes['formats']['audio']['path'] = $path;
            $book->audioFormat()->save(new AudioFormat($attributes['formats']['audio']));
            $book->audioFormat->getFileStorageService()->store($attributes['formats']['audio']['files']);
        }
    }

    private function storePaperFormat(Book $book, array $attributes): void
    {
        if (isset($attributes['formats']['paper'])) {
            $book->paperFormat()->save(new PaperFormat($attributes['formats']['paper']));
        }
    }

    private function storeCoverImage(Book $book, array $attributes): void
    {
        if (isset($attributes['cover_image'])) {
            $this->updateBookCoverImageAction->execute($book, $attributes['cover_image']);
        }
    }
}