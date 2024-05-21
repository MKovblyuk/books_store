<?php

namespace App\Repositories;

use App\Interfaces\Repositories\BookRepositoryInterface;
use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;
use App\Models\V1\Books\PaperFormat;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BookRepository implements BookRepositoryInterface {

    public function getAll()
    {
        return QueryBuilder::for(Book::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                'name',
                'publication_year',
                'language',
                'published_at',
                'publisher_id',
                'category_id'
            ])
            ->allowedFields([
                'id',
                'name',
                'description',
                'publication_year',
                'language',
                'cover_image_url',
                'published_at',
                'publisher_id',
                'category_id',
            ])
            ->allowedSorts([
                'id',
                'name',
                'publication_year',
                'language',
                'published_at',
                'publisher_id',
                'category_id'
            ])
            ->allowedIncludes([
                'publisher',
                'category',
                'authors',
            ])
            ->get();
    }

    public function store(array $attributes): bool
    {
        DB::transaction(function () use($attributes) {
            $book = Book::create($attributes);
            $book->authors()->saveMany(Author::find($attributes['authors_ids']));

            if (isset($attributes['formats']['paper'])) {
                $book->paperFormat()->save(new PaperFormat($attributes['formats']['paper']));
            }
            if (isset($attributes['formats']['audio'])) {
                $book->audioFormat()->save(new AudioFormat($attributes['formats']['audio']));
            }
            if (isset($attributes['formats']['electronic'])) {
                $book->electronicFormat()->save(new ElectronicFormat($attributes['formats']['electronic']));
            }
        });

        return true;
    }

    public function update(Book $book, array $attributes): bool
    {
        DB::transaction(function () use($book, $attributes) {
            $book->update($attributes);
            $book->authors()->sync(Author::find($attributes['authors_ids']));

            if (isset($attributes['formats']['paper'])) {
                $book->paperFormat->update($attributes['formats']['paper']);
            }
            if (isset($attributes['formats']['audio'])) {
                $book->audioFormat->update($attributes['formats']['audio']);
            }
            if (isset($attributes['formats']['electronic'])) {
                $book->electronicFormat->update($attributes['formats']['electronic']);
            }
        });

        return true;
    }

    public function destroy(Book $book): bool
    {
        return $book->delete();
    }
}
