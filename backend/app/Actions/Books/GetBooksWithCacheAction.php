<?php

namespace App\Actions\Books;

use Illuminate\Support\Facades\Cache;

class GetBooksWithCacheAction
{
    public const CACHE_TTL = 1200;

    public function __construct(
        private GetBooksAction $getBooksAction
    )
    {}

    public function execute(int $perPage = 10)
    { 
        $key = $this->createCacheKeyForRequest();
        $totalCount = Cache::store('redis')->get($key);

        if ($totalCount) {
            return $this->getBooksAction->getBuilder()->paginate($perPage, ['*'], 'page', null, $totalCount);
        }

        $paginator = $this->getBooksAction->getBuilder()->paginate($perPage);
        Cache::store('redis')->put($key, $paginator->total(), self::CACHE_TTL);
        return $paginator;
    }

    /**
     * For the same filter params return's the same cache key
     * @return string key based on request filter params
     */
    private function createCacheKeyForRequest(): string
    {
        return is_array(request('filter')) 
            ? 'books_count'. $this->sortByKeysAndValues(request('filter')) 
            : 'all_books_count';
    }

    // todo move into some other class
    /**
     * @return string sorted in format k1_v1_v2_k2_v1 ..
     */
    private function sortByKeysAndValues(array $arr): string
    {
        $res = '';
        $keys = array_keys($arr);
        sort($keys);

        foreach ($keys as $key) {
            if (is_array($arr[$key])) {
                $res .= '_'. $key . $this->sortByKeysAndValues($arr[$key]);
            } else {
                $values = explode(',', $arr[$key]);
                sort($values);
                $res .= '_'. $key .'_'. implode('_', $values);
            }
        }

        return $res;
    }
}