<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Size;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::latest()->get();
        return view('admin.inventory.index', compact('inventories'));
    }

    public function create()
    {
        $categories = Category::where('category_type', 0)->get(); // Main categories
        $subcategories = Category::where('category_type', 1)->get(); // Subcategories
        $subsubcategories = Category::where('category_type', 2)->get(); // Sub-subcategories

        $colors = Color::where('status', 'active')->get();
        $sizes = Size::where('status', 'active')->get();

        return view('admin.inventory.create', compact(
            'categories',
            'subcategories',
            'subsubcategories',
            'colors',
            'sizes'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|unique:inventories,sku',
            'fabric' => 'nullable|string|max:255',
            'fit' => 'nullable|string|max:255',
            'top_length' => 'nullable|string|max:255',
            'pattern' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'subsubcategory_id' => 'nullable|exists:categories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:active,inactive,draft',
            'featured' => 'required|in:active,inactive',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'variants' => 'required|json',
        ]);

        // Handle Image Upload
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $image) {
                $gallery[] = $image->store('products/gallery', 'public');
            }
            $data['gallery_images'] = json_encode($gallery);
        }

        // Decode variants JSON for storage
        $data['variants'] = json_decode($request->variants, true);
        dd($data);
        Inventory::create($data);

        return redirect()->route('admin.inventory.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        $categories = Category::all();
        $colors = Color::where('status', 'active')->get();
        $sizes = Size::where('status', 'active')->get();

        return view('admin.inventory.edit', compact('inventory', 'categories', 'colors', 'sizes'));
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|unique:inventories,slug,' . $inventory->id,
            'sku' => 'required|unique:inventories,sku,' . $inventory->id,
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'stock_qty' => 'required|integer',
            'stock_status' => 'required',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ]);

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $image) {
                $gallery[] = $image->store('products/gallery', 'public');
            }
            $data['gallery_images'] = json_encode($gallery);
        }

        $data['colors'] = json_encode($request->colors ?? []);
        $data['sizes'] = json_encode($request->sizes ?? []);

        $inventory->update($data);

        return redirect()->route('admin.inventory.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
