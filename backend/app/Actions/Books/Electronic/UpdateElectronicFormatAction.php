<?php 

namespace App\Actions\Books\Electronic;

use App\Models\V1\Books\Book;
use Illuminate\Support\Facades\DB;

class UpdateElectronicFormatAction
{
    public function execute(Book $book, array $attributes)
    {
        DB::transaction(function () use ($book, $attributes) {
            $book->electronicFormat->update($attributes);
            
            if (isset($attributes['files'])) {
                $book->electronicFormat->getFileStorageService()->delete();
                $book->electronicFormat->getFileStorageService()->store($attributes['files']);
            }
        });
    }
}