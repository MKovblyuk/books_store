<?php

namespace App\Http\Transformers;

class CategoriesStatTransformer extends StatTransformer
{
    protected function transformDataItem($item): array
    {
        return [
            'categoryId' => $item->category_id,
            'categoryName' => $item->category_name,
            'soldCount' => $item->books_sold_count,
        ];
    }
}