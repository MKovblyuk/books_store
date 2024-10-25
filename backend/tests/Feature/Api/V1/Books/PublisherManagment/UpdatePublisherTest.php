<?php

namespace Tests\Feature\Api\V1\Books\PublisherManagment;

use App\Models\V1\Books\Publisher;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;

class UpdatePublisherTest extends ApiV1TestCase
{
    use RefreshDatabase;

    public function test_put_updating_publishers_whithout_authentication(): void
    {
        $publisher = Publisher::factory()->create([
            'name' => 'Test For Update',
        ]);

        $this->putJson($this->apiUrl . '/publishers/' . $publisher->id, [
            'name' => 'New name',
        ])->assertStatus(401);
    }


    public function test_put_updating_publishers_by_customer(): void
    {
        $this->updatePublishersByPut($this->customer)->assertStatus(403);
    }

    public function test_put_updating_publishers_by_editor(): void
    {
        $this->updatePublishersByPut($this->editor)->assertSuccessful();
    }

    public function test_put_updating_publishers_by_admin(): void
    {
        $this->updatePublishersByPut($this->admin)->assertSuccessful();
    }

    private function updatePublishersByPut(Authenticatable $user): TestResponse
    {
        $publisher = Publisher::factory()->create([
            'name' => 'Test For Update',
        ]);

        return $this->actingAs($user)->putJson($this->apiUrl . '/publishers/' . $publisher->id, [
            'name' => 'Updated Publisher By Put',
        ]);
    }

    public function test_patch_updating_publishers_whithout_authentication(): void
    {
        $publisher = Publisher::factory()->create([
            'name' => 'Test For Update',
        ]);

        $this->patchJson($this->apiUrl . '/publishers/' . $publisher->id, [
            'name' => 'New name',
        ])->assertStatus(401);
    }

    public function test_patch_updating_publishers_by_customer(): void
    {
        $this->updatePublishersByPatch($this->customer)->assertStatus(403);
    }

    public function test_patch_updating_publishers_by_editor(): void
    {
        $this->updatePublishersByPatch($this->editor)->assertSuccessful();
    }

    public function test_patch_updating_publishers_by_admin(): void
    {
        $this->updatePublishersByPatch($this->editor)->assertSuccessful();
    }

    private function updatePublishersByPatch(Authenticatable $user): TestResponse
    {
        $publisher = Publisher::factory()->create([
            'name' => 'Test For Update',
        ]);

        return $this->actingAs($user)->patchJson($this->apiUrl . '/publishers/' . $publisher->id, [
            'name' => 'Updated Publisher By Patch',
        ]);
    }
}