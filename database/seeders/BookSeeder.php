<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $authors = Author::pluck('id')->all();
        Book::factory()->count(50)->create()->each(function (Book $b) use ($authors) {
            $b->authors()->sync(collect($authors)->random(rand(1, 2))->all());
        });
    }
}
