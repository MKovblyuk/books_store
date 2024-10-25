<?php

namespace Tests\Feature\Api\V1\Books\BookManagment;

use App\Enums\BookFormat;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\Category;
use App\Models\V1\Books\Publisher;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;

class DeleteBookFormatTest extends ApiV1TestCase
{
    use RefreshDatabase;

    public function test_deleting_book_format_without_authentification(): void
    {
        foreach (BookFormat::cases() as $bookFormat) {
            $book = Book::factory()
                ->for(Publisher::factory())
                ->for(Category::factory())
                ->create();
                
            $this->deleteJson($this->apiUrl . '/books/' . $book->id . '/' . $bookFormat->value)->assertStatus(401);
        }
    }

    public function test_deleting_book_format_by_customer(): void
    {
        foreach (BookFormat::cases() as $bookFormat) {
            $this->deleteBookFormat($this->customer, $bookFormat)->assertStatus(403);
        }
    }

    public function test_deleting_book_format_by_editor(): void
    {
        foreach (BookFormat::cases() as $bookFormat) {
            $this->deleteBookFormat($this->editor, $bookFormat)->assertNoContent();
        }
    }

    public function test_deleting_book_format_by_admin(): void
    {
        foreach (BookFormat::cases() as $bookFormat) {
            $this->deleteBookFormat($this->admin, $bookFormat)->assertNoContent();
        }
    }

    private function deleteBookFormat(Authenticatable $user, BookFormat $format): TestResponse
    {
        $book = Book::factory()
            ->for(Publisher::factory())
            ->for(Category::factory())
            ->create();
            
        return $this->actingAs($user)->deleteJson($this->apiUrl . '/books/' . $book->id . '/' . $format->value);
    }
}