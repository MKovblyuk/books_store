<?php

namespace App\Http\Transformers;

class BookFormatsStatTransformer extends StatTransformer
{
    protected function transformDataItem($item): array
    {
        return [
            'format' => $item->book_format,
            'soldCount' => $item->books_sold_count,
        ];
    }
}