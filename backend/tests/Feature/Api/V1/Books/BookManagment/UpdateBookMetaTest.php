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

class UpdateBookMetaTest extends ApiV1TestCase
{
    use RefreshDatabase;

    public function test_updating_book_without_authentification(): void
    {
        $book = Book::factory()
            ->for(Publisher::factory())
            ->for(Category::factory())
            ->create();

        $this->putJson($this->apiUrl . '/books/' . $book->id)->assertStatus(401);
        $this->patchJson($this->apiUrl . '/books/' . $book->id)->assertStatus(401);
    }

    public function test_updating_book_by_customer(): void
    {
        $this->putUpdateBook($this->customer)->assertStatus(403);
        $this->patchUpdateBook($this->customer)->assertStatus(403);
    }

    public function test_updating_book_by_editor(): void
    {
        $this->putUpdateBook($this->editor)->assertSuccessful();
        $this->patchUpdateBook($this->editor)->assertSuccessful();
    }

    public function test_updating_book_by_admin(): void
    {
        $this->putUpdateBook($this->admin)->assertSuccessful();
        $this->patchUpdateBook($this->admin)->assertSuccessful();
    }

    private function putUpdateBook(Authenticatable $user): TestResponse
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

        return $this->actingAs($user)->putJson($this->apiUrl . '/books/' . $book->id, $data);
    }

    private function patchUpdateBook(Authenticatable $user): TestResponse
    {
        $book = Book::factory()
            ->for(Publisher::factory())
            ->for(Category::factory())
            ->create();

        return $this->actingAs($user)->patchJson($this->apiUrl . '/books/' . $book->id, [
            'name' => 'New Name',
        ]);
    }
}