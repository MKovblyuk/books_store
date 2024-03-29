<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait AllowedIncludes {

    private function fieldIsIncluded(string $field, Request $request): bool
    {
        return isset($request->include) && in_array($field, explode(',', $request->include));
    }

    private function fieldIsNotIncluded(string $field, Request $request): bool
    {
        return !$this->fieldIsIncluded($field, $request);
    }
}