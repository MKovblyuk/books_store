<?php

namespace Tests\Feature\Api\V1\Books\BookManagment;

use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadBookTest extends ApiV1TestCase
{
    use RefreshDatabase;
    
    public function test_getting_books(): void
    {
        $this->getJson($this->apiUrl . '/books')->assertSuccessful();
    }
}