<?php

namespace Tests\Feature\Api\V1\Books\BookManagment;

use App\Models\V1\Books\Book;
use App\Models\V1\Books\Category;
use App\Models\V1\Books\ElectronicFormat;
use App\Models\V1\Books\Publisher;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;

class uploadCoverImageTest extends ApiV1TestCase
{
    use RefreshDatabase;

    private Book $book;
    private array $supportedFiles;
    private array $unsupportedFiles;

    protected function setUp(): void
    {
        parent::setUp();

        $this->supportedFiles = [
            UploadedFile::fake()->create('image', 10, MimeType::fromExtension('jpg')),
            UploadedFile::fake()->create('image', 10, MimeType::fromExtension('png')),
            UploadedFile::fake()->create('image', 10, MimeType::fromExtension('jpeg')),
        ];

        $this->unsupportedFiles = [
            UploadedFile::fake()->create('image1', 10, MimeType::fromExtension('gif')),
            UploadedFile::fake()->create('image2', 10, MimeType::fromExtension('tiff')),
            UploadedFile::fake()->create('image3', 10, MimeType::fromExtension('psd')),
            UploadedFile::fake()->create('image4', 10, MimeType::fromExtension('svg')),
        ];

        Storage::fake('electronic');

        $this->book = Book::factory()
            ->for(Publisher::factory())
            ->for(Category::factory())
            ->create();

        ElectronicFormat::factory()->for($this->book)->create(['path' => 'test_path']);
    }

    public function test_upload_book_cover_image_without_authentification(): void
    {
        $this->post(
            uri: $this->apiUrl . '/books/'. $this->book->id .'/uploadCoverImage',
            headers: $this->baseHeaders
        )->assertStatus(401);
    }

    public function test_upload_book_cover_image_by_customer(): void
    {
        foreach ($this->supportedFiles as $file) {
            $this->uploadCoverImage($this->customer, $file)->assertStatus(403);
        }
    }

    public function test_upload_book_cover_image_by_editor(): void
    {
        foreach ($this->supportedFiles as $file) {
            $this->uploadCoverImage($this->editor, $file)->assertCreated();
        }
    }

    public function test_upload_book_cover_image_by_admin(): void
    {
        foreach ($this->supportedFiles as $file) {
            $this->uploadCoverImage($this->admin, $file)->assertCreated();
        }
    }

    public function test_upload_unsupported_files(): void
    {
        foreach ($this->unsupportedFiles as $file) {
            $this->uploadCoverImage($this->admin, $file)->assertStatus(422);
        }
    }

    public function test_upload_more_than_the_permissible_size_file(): void
    {
        $image = UploadedFile::fake()->create('image', 30_000, MimeType::fromExtension('jpeg'));
        $this->uploadCoverImage($this->admin, $image)->assertStatus(422);
    }
    
    private function uploadCoverImage(Authenticatable $user, UploadedFile $image): TestResponse
    {
        return $this->actingAs($user)->post(
            uri: $this->apiUrl . '/books/'. $this->book->id .'/uploadCoverImage',
            data: [
                'image' => $image
            ]
        );
    }
}