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
        $categories = Category::latest()->get();
        return view('categories', compact('categories')); //display the counts in dashboard
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
    public function update(Request $request, Category $categories) // updates the database
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]); //same thing as store but for updates

        $categories->update($validated); //validate update
        return redirect()->back()->with('sucess', 'Category updated sucessfully.'); //redirect to previous page and display sucess msg
    }
    public function destroy(Category $categories) //deletes data in the database
    {
        $categories->delete(); //delete data
        return redirect()->back()->with('sucess', 'Category added sucessfully.'); //redirect to previous page and display sucess msg
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