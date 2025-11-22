<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_deleted', false)->get();
        return view('categories', compact('categories')); //display the counts in dashboard
    }

    public function trashed()
    {
        $categories = Category::where('is_deleted', true)->get();
        return view('trashed_categories', compact('categories'));
    }

    public function store(Request $request) //input data into the database, validates it first
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]); //add validation req for storing data and selecting the columns

        Category::create($validated); //validate data input
        return redirect()->back()->with('success', 'Category added sucessfully.'); //redirect to previous page and display sucess msg
    }

    public function edit(Category $category) //input data into the database, validates it first
    {
        return response()->json([
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse // updates the database
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
        ]);

        $category->update($validated); //validate update
        return redirect()->back()->with('sucess', 'Category updated sucessfully.'); //redirect to previous page and display sucess msg
    }
    
    public function destroy(Category $category) //deletes data in the database
    {
        // Check if category has active books
        if ($category->books()->where('is_deleted', false)->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete category that has active books.');
        }
        //$categories->delete(); hard delete 
        $category->update(['is_deleted' => true]); //soft delete
        return redirect()->back()->with('sucess', 'Category added sucessfully.'); //redirect to previous page and display sucess msg
    }

    public function restore($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['is_deleted' => false]);
        
        return redirect()->back()->with('success', 'Category restored successfully.');
    }

    public function forceDelete($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has any books (even deleted ones)
        if ($category->books()->exists()) {
            return redirect()->back()->with('error', 'Cannot permanently delete category that has books.');
        }
        
        $category->delete(); // Permanent delete
        
        return redirect()->back()->with('success', 'Category permanently deleted.');
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($this->category),
            ],
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'A category with this name already exists. Please choose a different name.',
        ];
    }
}