<?php

namespace App\Actions\Books;

use App\Actions\Books\Audio\StoreAudioFormatAction;
use App\Actions\Books\Electronic\StoreElectronicFormatAction;
use App\Actions\Books\Paper\UpdateOrCreatePaperFormatAction;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use Exception;
use Illuminate\Support\Facades\DB;

class StoreBookAction 
{
    public function __construct(
        private UpdateBookCoverImageAction $updateBookCoverImageAction,
        private DeleteBookCoverImageAction $deleteBookCoverImageAction,
        private UpdateOrCreatePaperFormatAction $updateOrCreatePaperFormatAction,
        private StoreElectronicFormatAction $storeElectronicFormatAction,
        private StoreAudioFormatAction $storeAudioFormatAction
    ){}

    public function execute(array $attributes): int
    {
        return DB::transaction(function () use($attributes) {
            $book = Book::create($attributes);
            $book->authors()->saveMany(Author::find($attributes['authors_ids']));

            try {
                if (isset($attributes['formats']['paper'])) {
                    $this->updateOrCreatePaperFormatAction->execute($book, $attributes['formats']['paper']);
                }
                if (isset($attributes['formats']['electronic'])) {
                    $this->storeElectronicFormatAction->execute($book, $attributes['formats']['electronic']);
                }
                if (isset($attributes['formats']['audio'])) {
                    $this->storeAudioFormatAction->execute($book, $attributes['formats']['audio']);
                }
                if (isset($attributes['cover_image'])) {
                    $this->updateBookCoverImageAction->execute($book, $attributes['cover_image']);
                }

                return $book->id;
            } catch (Exception $e) {
                $book->audioFormat?->getFileStorageService()->delete();
                $book->electronicFormat?->getFileStorageService()->delete();

                if ($book->cover_image_path) {
                    $this->deleteBookCoverImageAction->execute($book);
                }

                throw $e;
            }
        });
    }
}