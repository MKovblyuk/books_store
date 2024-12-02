<?php

namespace App\Actions\Books;

use App\Filters\DateFilter;
use App\Filters\FilterBooksByAuthors;
use App\Filters\FilterBooksByCategoryWithChild;
use App\Filters\FilterBooksByFormats;
use App\Filters\FilterBooksByPrice;
use App\Models\V1\Books\Book;
use App\Sorts\SortBooksByLikes;
use App\Sorts\SortBooksByPrice;
use App\Sorts\SortBooksBySellingCount;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class GetBooksAction 
{
    public function execute(int $perPage)
    {
        return QueryBuilder::for(Book::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::custom('author_id', new FilterBooksByAuthors()),
                AllowedFilter::custom('format', new FilterBooksByFormats()),
                AllowedFilter::custom('price_range', new FilterBooksByPrice()),
                AllowedFilter::custom('category_with_children', new FilterBooksByCategoryWithChild()),
                AllowedFilter::exact('publisher_id'),
                AllowedFilter::exact('category_id'),
                AllowedFilter::custom('created_at', new DateFilter()),
                AllowedFilter::custom('updated_at', new DateFilter()),
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
                'cover_image_path',
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
                'created_at',
                'updated_at',
                AllowedSort::custom('selling_count', new SortBooksBySellingCount()),
                AllowedSort::custom('likes', new SortBooksByLikes()),
                AllowedSort::custom('price', new SortBooksByPrice()),
            ])
            ->where(function ($query) {
                $query->whereIn('books.id', function ($query) {
                    $query->select('book_id')->from('paper_formats');
                })
                ->orWhereIn('books.id', function ($query) {
                    $query->select('book_id')->from('electronic_formats');
                })
                ->orWhereIn('books.id', function ($query) {
                    $query->select('book_id')->from('audio_formats');
                });
            })
            ->paginate($perPage);
    }
}