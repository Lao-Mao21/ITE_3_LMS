<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index() //show all categories in the database and display the data
    {
        $books = Book::latest()->get(); //add your model to fetch data
        $categories = Category::all(); //count active categories
        $books = Book::with('category')->get();
        return view('dashboard', compact('books', 'categories')); //add a view in app/resources/views
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'category_id' => 'nullable|exists:categories,id',
            'publisher' => 'nullable|string|max:255',
            'page_count' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:50',
        ]);

        Book::create($validated);

        return redirect()->back()->with('success', 'Book created successfully!');
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn,' . $book->id,
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'category_id' => 'nullable|exists:categories,id',
            'publisher' => 'nullable|string|max:255',
            'page_count' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:50',
            'is_available' => 'boolean',
        ]);

        $book->update($validated);

        return redirect()->back()->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();
        return redirect()->back()->with('success', 'Book deleted successfully!');
    }
}