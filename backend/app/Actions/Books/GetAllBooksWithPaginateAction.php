<?php

namespace App\Actions\Books;

use App\Filters\FilterBooksByAuthors;
use App\Filters\FilterBooksByFormats;
use App\Filters\FilterBooksByPrice;
use App\Helpers\DirectoryNameGenerator;
use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;
use App\Models\V1\Books\PaperFormat;
use App\Sorts\BooksSellingCountSort;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class GetAllBooksWithPaginateAction 
{
    public function execute(int $per_page)
    {
        // $per_page = request()->get('per_page', 10);

        return QueryBuilder::for(Book::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::custom('author_id', new FilterBooksByAuthors()),
                AllowedFilter::custom('format', new FilterBooksByFormats()),
                AllowedFilter::custom('price_range', new FilterBooksByPrice()),
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
            ->allowedIncludes([
                'publisher',
                'category',
                'authors',
                'reviews',
                'fragments',
            ])
            ->allowedSorts([
                'id',
                'name',
                'publication_year',
                'language',
                'published_at',
                'publisher_id',
                'category_id',
                AllowedSort::custom('selling_count', new BooksSellingCountSort()),
            ])
            ->paginate($per_page);
    }
}