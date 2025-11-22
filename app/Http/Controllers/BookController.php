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
        $books = Book::where('is_deleted', false)->get();
        //$books = Book::latest()->get(); //add your model to fetch data
        $categories = Category::active()->get();
        return view('dashboard', compact('books', 'categories')); //add a view in app/resources/views
    }

    public function trashed()
    {
        $books = Book::with('category')->where('is_deleted', true)->get();// Show only deleted books
        return view('trashed_books', compact('books'));
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

    public function edit(Book $book)
    {
        return response()->json([
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'isbn' => $book->isbn,
            'publication_year' => $book->publication_year,
            'category_id' => $book->category_id,
            'publisher' => $book->publisher,
            'page_count' => $book->page_count,
            'language' => $book->language,
        ]);
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
        ]);

        $book->update($validated);

        return redirect()->back()->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book): RedirectResponse
    {
        // $book->delete(); hard delete
        $book->update(['is_deleted' => true]); //soft delete
        return redirect()->back()->with('success', 'Book deleted successfully!');
    }

    public function restore($id)
    {
        $book = Book::findOrFail($id);
        $book->update(['is_deleted' => false]);
        
        return redirect()->route('books.trashed')
            ->with('success', 'Book restored successfully.');
    }

    public function forceDelete($id)
    {
        $book = Book::findOrFail($id);
        $book->delete(); // This will permanently delete
        
        return redirect()->route('books.trashed')
            ->with('success', 'Book permanently deleted.');
    }
}