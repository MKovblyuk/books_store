<?php

namespace Tests\Feature\Api\V1\Books\PublisherManagment;

use App\Http\Resources\V1\Books\PublisherCollection;
use App\Models\V1\Books\Publisher;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadPublisherTest extends ApiV1TestCase
{
    use RefreshDatabase;

    public function test_getting_publishers(): void
    {
        $this->getJson($this->apiUrl . '/publishers')->assertSuccessful();
    }
}