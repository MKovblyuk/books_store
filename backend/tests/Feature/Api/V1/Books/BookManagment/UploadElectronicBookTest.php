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

class UploadElectronicBookTest extends ApiV1TestCase
{
    use RefreshDatabase;

    private Book $book;
    private array $supportedFiles;
    private array $unsupportedFiles;

    protected function setUp(): void
    {
        parent::setUp();

        $this->supportedFiles = [
            UploadedFile::fake()->create('eFile', 10, MimeType::fromExtension('pdf')),
        ];

        $this->unsupportedFiles = [
            UploadedFile::fake()->create('eFile1', 10, MimeType::fromExtension('doc')),
            UploadedFile::fake()->create('eFile2', 10, MimeType::fromExtension('docx')),
            UploadedFile::fake()->create('eFile3', 10, MimeType::fromExtension('txt')),
            UploadedFile::fake()->create('eFile4', 10, MimeType::fromExtension('epub')),
        ];

        Storage::fake('electronic');

        $this->book = Book::factory()
            ->for(Publisher::factory())
            ->for(Category::factory())
            ->create();

        ElectronicFormat::factory()->for($this->book)->create(['path' => 'test_path']);
    }

    public function test_upload_electronic_book_without_authentification(): void
    {
        $this->post(
            uri: $this->apiUrl . '/books/upload/electronic',
            headers: $this->baseHeaders,
        )->assertStatus(401);
    }

    public function test_upload_electronic_book_by_customer(): void
    {
        $this->uploadElectronicBook($this->customer, $this->supportedFiles)->assertStatus(403);
    }

    public function test_upload_electronic_book_by_editor(): void
    {
        $this->uploadElectronicBook($this->editor, $this->supportedFiles)->assertCreated();
    }

    public function test_upload_electronic_book_by_admin(): void
    {
        $this->uploadElectronicBook($this->admin, $this->supportedFiles)->assertCreated();
    }

    public function test_upload_electronic_files_with_the_same_extension(): void
    {
        $this->uploadElectronicBook($this->admin, $this->supportedFiles)->assertCreated();
        $this->uploadElectronicBook($this->admin, $this->supportedFiles)->assertStatus(422);
    }

    public function test_upload_unsupported_files(): void
    {
        $this->uploadElectronicBook($this->admin, $this->unsupportedFiles)->assertStatus(422);
    }

    public function test_upload_more_than_the_permissible_size_file(): void
    {
        $file = UploadedFile::fake()->create('eFile', 300_000, MimeType::fromExtension('pdf'));
        $this->uploadElectronicBook($this->admin, [$file])->assertStatus(422);
    }
    
    private function uploadElectronicBook(Authenticatable $user, array $files): TestResponse
    {
        return $this->actingAs($user)->post(
            uri: $this->apiUrl . '/books/upload/electronic',
            data: [
                'bookId' => $this->book->id,
                'files' => $files
            ]
        );
    }
}