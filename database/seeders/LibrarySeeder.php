<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder; 
use App\Models\Category;
use App\Models\Book;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create Categories
        $fiction = Category::create([
            'name' => 'Fiction',
            'description' => 'Novels and short stories'
        ]);

        $scifi = Category::create([
            'name' => 'Science Fiction',
            'description' => 'Sci-fi books'
        ]);

        $programming = Category::create([
            'name' => 'Programming',
            'description' => 'Computer programming books'
        ]);

        // Create Books with categories
        Book::create([
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'isbn' => '9780743273565',
            'publication_year' => 1925,
            'category_id' => $fiction->id,
            'publisher' => 'Scribner',
            'page_count' => 180,
            'language' => 'English'
        ]);

        Book::create([
            'title' => 'Dune',
            'author' => 'Frank Herbert',
            'isbn' => '9780441172719',
            'publication_year' => 1965,
            'category_id' => $scifi->id,
            'publisher' => 'Ace Books',
            'page_count' => 412,
            'language' => 'English'
        ]);

        // Create a book without category (nullable foreign key)
        Book::create([
            'title' => 'Unknown Book',
            'author' => 'Anonymous',
            'isbn' => '9780000000000',
            'publication_year' => 2020,
            'category_id' => null, // This demonstrates nullable foreign key
            'publisher' => 'Unknown Publisher',
            'page_count' => 100,
            'language' => 'English'
        ]);
    }
}
