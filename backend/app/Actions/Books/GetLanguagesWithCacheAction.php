<?php

namespace App\Actions\Books;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GetLanguagesWithCacheAction
{
    public const CACHE_TTL = 12000;

    public function __construct(
        private GetLanguagesAction $getLanguagesAction
    )
    {}

    public function execute(): Collection
    {
        return Cache::store('redis')->remember('books_languages', self::CACHE_TTL, function () {
            return $this->getLanguagesAction->execute();
        });
    }

    public function updateCache(): bool
    {
        $languages = $this->getLanguagesAction->execute();
        return Cache::store('redis')->put('books_languages', $languages, self::CACHE_TTL);
    }
}