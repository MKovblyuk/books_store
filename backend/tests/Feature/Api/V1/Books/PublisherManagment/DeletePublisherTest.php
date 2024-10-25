<?php

namespace Tests\Feature\Api\V1\Books\PublisherManagment;

use App\Models\V1\Books\Publisher;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;

class DeletePublisherTest extends ApiV1TestCase
{
    use RefreshDatabase;

    public function test_deleting_publishers_whithout_authentication() : void
    {
        $publisher = Publisher::factory()->create([
            'name' => 'Publisher For Deleting',
        ]);

        $this->delete(
            uri: $this->apiUrl . '/publishers/' . $publisher->id, 
            headers: $this->baseHeaders
        )->assertStatus(401);
    }

    public function test_deleting_publishers_by_customer(): void
    {
        $this->deletePublishers($this->customer)->assertStatus(403);
    }

    public function test_deleting_publishers_by_editor(): void
    {
        $this->deletePublishers($this->editor)->assertNoContent();
    }

    public function test_deleting_publishers_by_admin(): void
    {
        $this->deletePublishers($this->admin)->assertNoContent();
    }

    private function deletePublishers(Authenticatable $user): TestResponse
    {
        $publisher = Publisher::factory()->create([
            'name' => 'Publisher For Deleting',
        ]);

        return $this->actingAs($user)->delete($this->apiUrl . '/publishers/' . $publisher->id);
    }
}