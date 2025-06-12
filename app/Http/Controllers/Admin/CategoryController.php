<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->orderBy('id', 'asc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $mainCategories = Category::where('category_type', 0)->get();
        $subCategories = Category::where('category_type', 1)->get();

        return view('admin.categories.create', compact('mainCategories', 'subCategories'));
    }

    public function store(StoreCategoryRequest $req)
    {
        Category::create($req->validated());
        return to_route('admin.categories.index')
            ->with('success', 'Category created');
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::where('id', '!=', $category->id)
            ->where('category_type', '<', $category->category_type)
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(StoreCategoryRequest $req, Category $category)
    {
        $data = $req->validated();

        // Force parent_id null for main categories
        if ($data['category_type'] == 0) {
            $data['parent_id'] = null;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Deleted');
    }
}
