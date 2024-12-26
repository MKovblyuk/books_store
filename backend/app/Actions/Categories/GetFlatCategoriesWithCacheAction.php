<?php

namespace App\Actions\Categories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GetFlatCategoriesWithCacheAction
{
    public const CACHE_TTL = 12000;

    public function __construct(
        private GetFlatCategoriesAction $getFlatCategoriesAction
    )
    {}

    public function execute(): Collection
    {
        return Cache::store('redis')->remember('flat_categories', self::CACHE_TTL, function () {
            return $this->getFlatCategoriesAction->execute();
        });
    }

    public function updateCache(): bool
    {
        $categories = $this->getFlatCategoriesAction->execute();
        return Cache::store('redis')->put('flat_categories', $categories, self::CACHE_TTL);
    }
}