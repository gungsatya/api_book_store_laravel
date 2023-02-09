<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\Book;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::create([
             'name'     => 'I Gusti Bagus Ngurah Satya Wibawa',
             'email'    => 'igbn.satyawibawa@gmail.com',
             'password' => bcrypt('Rahasia123')
         ]);

         Tag::insert([
             ['name' => 'Dictionary'],
             ['name' => 'Novel'],
             ['name' => 'Sci-fi'],
             ['name' => 'Encyclopedia'],
         ]);

         $tags = Tag::all();

         Author::factory()
             ->count(5)
             ->create()
             ->each(function (Author $author) use($tags) {
                $book_count_generate = random_int(1,4);
                $author
                    ->books()
                    ->saveMany(
                        Book::factory()
                            ->count($book_count_generate)
                            ->make()
                    );

                $author
                    ->books
                    ->each(function (Book $book) use ($tags) {
                        $book->tags()->sync($tags->random(2));
                });
         });
    }
}
