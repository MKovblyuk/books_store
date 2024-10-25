<?php

namespace Tests\Feature\Api\V1\Books\PublisherManagment;

use App\Models\V1\Books\Publisher;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;

class CreatePublisherTest extends ApiV1TestCase
{
    use RefreshDatabase;

    public function test_creating_publishers_whithout_authentication(): void
    {
        $this->postJson($this->apiUrl . '/publishers')->assertStatus(401);
    }

    public function test_creating_publishers_by_customer(): void
    {
        $this->createPublishers($this->customer)->assertStatus(403);
    }

    public function test_creating_publishers_by_admin(): void
    {
        $this->createPublishers($this->admin)->assertCreated();
    }

    public function test_creating_publishers_by_editor(): void
    {
        $this->createPublishers($this->editor)->assertCreated();
    }

    private function createPublishers(Authenticatable $user): TestResponse
    {
        return $this->actingAs($user)->postJson(
            uri: $this->apiUrl . '/publishers',
            data: Publisher::factory()->make()->toArray());
    }
}