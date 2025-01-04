<?php

namespace App\Actions\Books;

use App\Helpers\FileNameGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoreFragmentsAction
{
    private FileNameGenerator $generator;

    public function __construct()
    {
        $this->generator = new FileNameGenerator();
    }

    public function execute(array $attributes) 
    {
        $insertData = [];

        foreach ($attributes as $attr) {
            foreach ($attr['fragments'] as $file) {
                $path = $this->generator->generate($attr['id'], 'image');
                Storage::disk('preview_fragments')->put($path, $file->getContent());

                $insertData[] = [
                    'book_id' => $attr['id'],
                    'path' => $path,
                ];
            }
        }

        DB::table('fragments')->insert($insertData);
    }
}