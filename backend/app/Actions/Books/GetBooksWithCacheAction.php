<?php

namespace App\Actions\Books;

use App\Helpers\ArrayUtils;
use Illuminate\Support\Facades\Cache;

class GetBooksWithCacheAction
{
    public const CACHE_TTL = 12000;
    public const MAX_FILTER_FIELDS_FOR_CACHE = 5;

    public function __construct(
        private GetBooksAction $getBooksAction
    )
    {}

    public function execute(int $perPage = 10)
    { 
        if ($this->isNeedToUseCache()) {
            $key = $this->createCacheKeyForRequest();
            $totalCount = Cache::store('redis')->get($key);
    
            if ($totalCount !== null) {
                return $this->getBooksAction->getBuilder()->paginate($perPage, ['*'], 'page', null, $totalCount);
            }
    
            $paginator = $this->getBooksAction->getBuilder()->paginate($perPage);
            Cache::store('redis')->put($key, $paginator->total(), self::CACHE_TTL);
            return $paginator;
        }

        return $this->getBooksAction->getBuilder()->paginate($perPage);
    }

    private function isNeedToUseCache(): bool
    {
        $items_count = 0;

        if (isset(request('filter')['name'])) {
            return false;
        }

        foreach (collect(request('filter'))->values() as $value) {
            $items_count += count(explode(',', $value));
        }

        return $items_count <= self::MAX_FILTER_FIELDS_FOR_CACHE;
    }

    /**
     * For the same filter params return's the same cache key
     * @return string key based on request filter params
     */
    private function createCacheKeyForRequest(): string
    {
        return is_array(request('filter')) 
            ? 'books_count'. ArrayUtils::sortByKeysAndValues(request('filter')) 
            : 'all_books_count';
    }
}