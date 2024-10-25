<?php

namespace Tests\Feature\Api\V1\Books\BookManagment;

use App\Models\V1\Books\Book;
use App\Models\V1\Books\Category;
use App\Models\V1\Books\Publisher;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;

class DeleteBookTest extends ApiV1TestCase
{
    use RefreshDatabase;

    public function test_deleting_book_without_authentification(): void
    {
        $book = Book::factory()
            ->for(Publisher::factory())
            ->for(Category::factory())
            ->create();
            
        $this->deleteJson($this->apiUrl . '/books/' . $book->id)->assertStatus(401);
    }

    public function test_deleting_book_by_customer(): void
    {
        $this->deleteBook($this->customer)->assertStatus(403);
    }

    public function test_deleting_book_by_editor(): void
    {
        $this->deleteBook($this->editor)->assertNoContent();
    }

    public function test_deleting_book_by_admin(): void
    {
        $this->deleteBook($this->admin)->assertNoContent();
    }

    private function deleteBook(Authenticatable $user): TestResponse
    {
        $book = Book::factory()
            ->for(Publisher::factory())
            ->for(Category::factory())
            ->create();

        return $this->actingAs($user)->deleteJson($this->apiUrl . '/books/' . $book->id);
    }
}