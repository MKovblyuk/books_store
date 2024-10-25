<?php

namespace Tests\Feature\Api\V1;

use App\Enums\UserRole;
use App\Models\V1\User;
use Tests\TestCase;

class ApiV1TestCase extends TestCase
{
    protected string $apiUrl = 'api/v1';

    protected User $customer;
    protected User $editor;
    protected User $admin;

    protected array $baseHeaders;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create([
            'role' => UserRole::Customer
        ]);
        $this->editor = User::factory()->create([
            'role' => UserRole::Editor
        ]);
        $this->admin = User::factory()->create([
            'role' => UserRole::Admin
        ]);

        $this->baseHeaders = [
            'Accept' => 'application/json',
        ];
    }
}
