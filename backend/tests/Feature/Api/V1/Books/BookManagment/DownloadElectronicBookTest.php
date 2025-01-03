<?php

namespace Tests\Feature\Api\V1\Books\BookManagment;

use App\Enums\BookFormat;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\ElectronicFormat;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DownloadElectronicBookTest extends DownloadBookTestCase
{
    use RefreshDatabase;

    private string $fileExtension = 'pdf';

    protected function setUp(): void
    {
        parent::setUp();
        $this->createFileForBook($this->book);
    }

    public function test_downloading_electronic_book_without_authentification(): void
    {
        $this->get(
            uri: $this->apiUrl . '/books/electronic/'. $this->book->id .'/download/' . $this->fileExtension,
            headers: $this->baseHeaders
        )->assertStatus(401);
    }

    public function test_downloading_electronic_book(): void
    {
        $this->createOrder(BookFormat::Electronic);
        
        $this->actingAs($this->customer)->get(
            uri: $this->apiUrl . '/books/electronic/'. $this->book->id .'/download/' . $this->fileExtension,
            headers: $this->baseHeaders
        )
        ->assertDownload()
        ->assertSuccessful();
    }

    public function test_downloading_electronic_book_by_non_owner(): void
    {
        $this->actingAs($this->customer)->get(
            uri: $this->apiUrl . '/books/electronic/'. $this->book->id .'/download/' . $this->fileExtension,
            headers: $this->baseHeaders
        )->assertStatus(403);
    }

    private function createFileForBook(Book $book): void
    {
        Storage::fake('electronic');

        $file = UploadedFile::fake()->create('eFile', 2000, MimeType::fromExtension($this->fileExtension));
        $electronicFormat = ElectronicFormat::factory()->for($book)->create(['path' => 'test_path']);
        $electronicFormat->getFileStorageService()->store([$file]);
    }
}