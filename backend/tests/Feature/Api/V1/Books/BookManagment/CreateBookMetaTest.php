<?php

namespace Tests\Feature\Api\V1\Books\BookManagment;

use App\Models\V1\Books\AudioFormat;
use App\Models\V1\Books\Author;
use App\Models\V1\Books\Book;
use App\Models\V1\Books\Category;
use App\Models\V1\Books\ElectronicFormat;
use App\Models\V1\Books\PaperFormat;
use App\Models\V1\Books\Publisher;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\Feature\Api\V1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;

class CreateBookMetaTest extends ApiV1TestCase
{
    use RefreshDatabase;

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
        $book = Book::factory()
            ->for(Publisher::factory())
            ->for(Category::factory())
            ->create();

        $data = $book->toArray();
        $data['authorsIds'] = Author::factory(2)->create()->pluck('id');
        $data['formats']['paper'] = PaperFormat::factory()->for($book)->create()->toArray();
        $data['formats']['electronic'] = ElectronicFormat::factory()->for($book)->create()->toArray();
        $data['formats']['audio'] = AudioFormat::factory()->for($book)->create()->toArray();

        return $this->actingAs($user)->postJson($this->apiUrl . '/books', $data);
    }
}