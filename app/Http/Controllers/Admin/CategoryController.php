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
        $data = $req->validated();
        if ($req->hasFile('image')) {
            $filename = time() . '.' . $req->image->extension();
            $req->image->move(public_path('uploads/categories'), $filename);
            $data['image'] = 'uploads/categories/' . $filename;
        }

        Category::create($data);
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

        if ($data['category_type'] == 0) {
            $data['parent_id'] = null;
        }

        if ($req->hasFile('image')) {
            $filename = time() . '.' . $req->image->extension();
            $req->image->move(public_path('uploads/categories'), $filename);
            $data['image'] = 'uploads/categories/' . $filename;

            // optionally delete old image
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Deleted');
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = Category::where('parent_id', $request->category_id)
            ->where('category_type', 1)
            ->get();

        return response()->json($subcategories);
    }

    public function getSubsubcategories(Request $request)
    {
        $subcategoryId = $request->subcategory_id;

        $subsubcategories = Category::where('parent_id', $subcategoryId)
            ->where('category_type', 2) // Sub-subcategory type
            ->get();

        return response()->json($subsubcategories);
    }
}
