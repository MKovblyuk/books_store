<?php

namespace App\Repositories;

use App\Enums\BookFormat;
use App\Filters\FilterBooksByAuthors;
use App\Filters\FilterBooksByFormats;
use App\Filters\FilterBooksByPrice;
use App\Interfaces\Repositories\BookRepositoryInterface;
use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;
use App\Models\V1\Books\PaperFormat;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BookRepository implements BookRepositoryInterface {

    public function getAll()
    {
        // dd(request()->get('filter')['format']);
        // $book_formats = isset(request()->get('filter')['format']) ? request()->get('filter')['format'] : null;
        // $book_format = explode(',', $book_formats)[0];
        // dd($book_format);

        $per_page = request()->get('per_page', 10);

        return QueryBuilder::for(Book::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::custom('author_id', new FilterBooksByAuthors()),
                AllowedFilter::custom('format', new FilterBooksByFormats()),
                // AllowedFilter::custom('price_range', new FilterBooksByPrice()),
                AllowedFilter::exact('publisher_id'),
                AllowedFilter::exact('category_id'),
                'name',
                'publication_year',
                'language',
                'published_at',
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
                'reviews',
            ])
            ->paginate($per_page);
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
