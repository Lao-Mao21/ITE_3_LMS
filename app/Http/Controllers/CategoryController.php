<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('dashboard', compact('categories')); //display the counts in dashboard
    }

    public function store(Request $request) //input data into the database, validates it first
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]); //add validation req for storing data and selecting the columns

        Course::create($validated); //validate data input
        return redirect()->back()->with('success', 'Course added sucessfully.'); //redirect to previous page and display sucess msg
    }
    public function update(Request $request, Course $course) // updates the database
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]); //same thing as store but for updates

        $course->update($validated); //validate update
        return redirect()->back()->with('sucess', 'Course updated sucessfully.'); //redirect to previous page and display sucess msg
    }
    public function destroy(Course $course) //deletes data in the database
    {
        $course->delete(); //delete data
        return redirect()->back()->with('sucess', 'Course added sucessfully.'); //redirect to previous page and display sucess msg
    }
}