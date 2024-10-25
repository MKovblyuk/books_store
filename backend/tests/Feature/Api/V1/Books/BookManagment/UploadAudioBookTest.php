<?php

namespace Tests\Feature\Api\V1\Books\BookManagment;

use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\Category;
use App\Models\V1\Books\Publisher;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;

class UploadAudioBookTest extends ApiV1TestCase
{
    use RefreshDatabase;

    private Book $book;
    private array $supportedFiles;
    private array $unsupportedFiles;

    protected function setUp(): void
    {
        parent::setUp();

        $this->supportedFiles = [
            UploadedFile::fake()->create('audioFile', 10, MimeType::fromExtension('mp3')),
        ];

        $this->unsupportedFiles = [
            UploadedFile::fake()->create('audioFile1', 10, MimeType::fromExtension('wav')),
            UploadedFile::fake()->create('audioFile2', 10, MimeType::fromExtension('flac')),
            UploadedFile::fake()->create('audioFile3', 10, MimeType::fromExtension('aiff')),
            UploadedFile::fake()->create('audioFile4', 10, MimeType::fromExtension('mp4')),
        ];

        Storage::fake('audio');

        $this->book = Book::factory()
            ->for(Publisher::factory())
            ->for(Category::factory())
            ->create();

        AudioFormat::factory()->for($this->book)->create(['path' => 'test_path']);
    }

    public function test_upload_audio_book_without_authentification(): void
    {
        $this->post(
            uri: $this->apiUrl . '/books/upload/audio',
            headers: $this->baseHeaders,
        )->assertStatus(401);
    }

    public function test_upload_audio_book_by_customer(): void
    {
        $this->uploadAudioBook($this->customer, $this->supportedFiles)->assertStatus(403);
    }

    public function test_upload_audio_book_by_editor(): void
    {
        $this->uploadAudioBook($this->editor, $this->supportedFiles)->assertCreated();
    }

    public function test_upload_audio_book_by_admin(): void
    {
        $this->uploadAudioBook($this->admin, $this->supportedFiles)->assertCreated();
    }

    public function test_upload_audio_files_with_the_same_extension(): void
    {
        $this->uploadAudioBook($this->admin, $this->supportedFiles)->assertCreated();
        $this->uploadAudioBook($this->admin, $this->supportedFiles)->assertStatus(422);
    }

    public function test_upload_unsupported_files(): void
    {
        $this->uploadAudioBook($this->admin, $this->unsupportedFiles)->assertStatus(422);
    }

    public function test_upload_more_than_the_permissible_size_file(): void
    {
        $file = UploadedFile::fake()->create('audioFile', 300_000, MimeType::fromExtension('mp3'));
        $this->uploadAudioBook($this->admin, [$file])->assertStatus(422);
    }
    
    private function uploadAudioBook(Authenticatable $user, array $files): TestResponse
    {
        return $this->actingAs($user)->post(
            uri: $this->apiUrl . '/books/upload/audio',
            data: [
                'bookId' => $this->book->id,
                'files' => $files
            ]
        );
    }
}