<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AdminCategoryController extends Controller
{
    public function index()
    {
        // Fetch categories from the database
        $categories = Category::all();

        // Pass categories to the view
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255|unique:categories,category_name',
        ], [
            'categoryName.unique' => 'The category name already exists.',
        ]);

        $category = new Category();
        $category->category_name = $request->input('categoryName');
        $category->admin_id = Auth::user()->id;
        $category->save();

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255|unique:categories,category_name,' . $category->id,
        ], [
            'categoryName.unique' => 'The category name already exists.',
        ]);

        $category->update([
            'category_name' => $request->categoryName
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
