<?php

namespace Tests\Feature\Api\V1\Books\BookManagment;

use App\Enums\BookFormat;
use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Book;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DownloadAudioBookTest extends DownloadBookTestCase
{
    use RefreshDatabase;

    private string $fileExtension = 'mp3';

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAudioFileForBook($this->book);
    }

    public function test_downloading_audio_book_without_authentification(): void
    {
        $this->get(
            uri: $this->apiUrl . '/books/audio/'. $this->book->id .'/download/' . $this->fileExtension,
            headers: $this->baseHeaders
        )->assertStatus(401);
    }

    public function test_downloading_audio_book(): void
    {
        $this->createOrder(BookFormat::Audio);
        
        $this->actingAs($this->customer)->get(
            uri: $this->apiUrl . '/books/audio/'. $this->book->id .'/download/' . $this->fileExtension,
            headers: $this->baseHeaders
        )
        ->assertDownload()
        ->assertSuccessful();
    }

    public function test_downloading_audio_book_by_non_owner(): void
    {
        $this->actingAs($this->customer)->get(
            uri: $this->apiUrl . '/books/audio/'. $this->book->id .'/download/' . $this->fileExtension,
            headers: $this->baseHeaders
        )->assertStatus(403);
    }

    private function createAudioFileForBook(Book $book): void
    {
        Storage::fake('audio');

        $file = UploadedFile::fake()->create('audioFile', 2000, MimeType::fromExtension($this->fileExtension));
        $audioFormat = AudioFormat::factory()->for($book)->create(['path' => 'test_path']);
        $audioFormat->getFileStorageService()->store([$file]);
    }
}