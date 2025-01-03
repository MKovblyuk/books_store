<?php

namespace Tests\Feature\Api\V1\Books\BookManagment;

use App\Models\V1\Books\Author;
use App\Models\V1\Books\Category;
use App\Models\V1\Books\Publisher;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;

class CreateBookTest extends ApiV1TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('audio');
        Storage::fake('electronic');
    }

    public function test_creating_book_without_authentification(): void
    {
        $this->postJson($this->apiUrl . '/books')->assertStatus(401);
    }

    public function test_creating_book_by_customer(): void
    {
        $this->createBook($this->customer)->assertStatus(403);
    }

    public function test_creating_book_by_editor(): void
    {
        $this->createBook($this->editor)->assertCreated();
    }

    public function test_creating_book_by_admin(): void
    {
        $this->createBook($this->admin)->assertCreated();
    }

    private function createBook(Authenticatable $user): TestResponse
    {
        $meta = [
            'name' => 'Test Name',
            'description' => 'Tets Description',
            'language' => 'English',
            'publisherId' => Publisher::factory()->create()['id'],
            'categoryId' => Category::factory()->create()['id'],
            'publicationYear' => 2015,
            'authorsIds' => Author::factory(2)->create()->pluck('id'),
            'formats' => [
                'paper' => [
                    'price' => 100,
                    'discount' => 50,
                    'pageCount' => 70,
                    'quantity' => 10,
                ],
                'audio' => [
                    'price' => 100,
                    'discount' => 50,
                    'duration' => 70,
                ],
                'electronic' => [
                    'price' => 100,
                    'discount' => 50,
                    'pageCount' => 70,
                ]
            ]
        ];

        return $this->actingAs($user)->post($this->apiUrl . '/books', [
            'data' => json_encode($meta),
            'audioFiles' => [
                UploadedFile::fake()->create('audioFile', 240_000, MimeType::fromExtension('mp3'))
            ],
            'electronicFiles' => [
                UploadedFile::fake()->create('eFile', 2000, MimeType::fromExtension('pdf'))
            ],
        ]);
    }
}