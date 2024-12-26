<?php

namespace App\Actions\Categories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GetCategoriesWithCacheAction 
{
    public const CACHE_TTL = 12000;

    public function __construct(
        private GetCategoriesAction $getCategoriesAction
    ){}

    public function execute(): Collection
    {
        return Cache::store('redis')->remember('categories', self::CACHE_TTL, function () {
            return $this->getCategoriesAction->execute();
        });
    }

    public function updateCache(): bool
    {
        $categories = $this->getCategoriesAction->execute();
        return Cache::store('redis')->put('categories', $categories, self::CACHE_TTL);
    }
}