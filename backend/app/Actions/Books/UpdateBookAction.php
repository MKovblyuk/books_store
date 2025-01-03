<?php

namespace App\Actions\Books;

use App\Actions\Books\Audio\UpdateOrCreateAudioFormatAction;
use App\Actions\Books\Electronic\UpdateOrCreateElectronicFormatAction;
use App\Actions\Books\Paper\UpdateOrCreatePaperFormatAction;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateBookAction 
{
    public function __construct(
        private UpdateOrCreatePaperFormatAction $updateOrCreatePaperFormatAction,
        private UpdateOrCreateElectronicFormatAction $updateOrCreateElectronicFormatAction,
        private UpdateOrCreateAudioFormatAction $updateOrCreateAudioFormatAction,
        private UpdateBookCoverImageAction $updateBookCoverImageAction,
        private DeleteBookCoverImageAction $deleteBookCoverImageAction
    )
    {}

    public function execute(Book $book, array $attributes): bool
    {
        return DB::transaction(function () use($book, $attributes) {      
            $book->update($attributes);

            if (isset($attributes['authors_ids'])) {
                $book->authors()->sync(Author::find($attributes['authors_ids']));
            }

            try {
                if (isset($attributes['formats']['paper'])) {
                    $this->updateOrCreatePaperFormatAction->execute($book, $attributes['formats']['paper']);
                }
                if (isset($attributes['formats']['electronic'])) {
                    $this->updateOrCreateElectronicFormatAction->execute($book, $attributes['formats']['electronic']);
                }
                if (isset($attributes['formats']['audio'])) {
                    $this->updateOrCreateAudioFormatAction->execute($book, $attributes['formats']['audio']);
                }
                if (isset($attributes['cover_image'])) {
                    $this->updateBookCoverImageAction->execute($book, $attributes['cover_image']);
                }

                return true;
            } catch(Exception $e) {
                if (isset($attributes['formats']['audio'])) {
                    $book->audioFormat->getFileStorageService()->delete();
                }
                if (isset($attributes['formats']['electronic'])) {
                    $book->electronicFormat->getFileStorageService()->delete();
                }
                if (isset($attributes['cover_image'])) {
                    $this->deleteBookCoverImageAction->execute($book);
                }

                throw $e;
            }
        });
    }
}