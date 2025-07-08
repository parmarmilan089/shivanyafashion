<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (\DB::table('inventories')->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
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

        // Use the unique slug generator
        $data['slug'] = $this->generateUniqueSlug($data['name']);

        // Create the inventory and assign to $inventory
        $inventory = Inventory::create($data);

        // Decode variants JSON for storage
        $variants = json_decode($request->variants, true);

        if (is_array($variants)) {
            foreach ($variants as $variant) {
                if (isset($variant['sizes']) && is_array($variant['sizes'])) {
                    foreach ($variant['sizes'] as $size) {
                        \DB::table('product_variants')->insert([
                            'inventory_id' => $inventory->id,
                            'color_id' => $variant['color_id'],
                            'size_id' => $size['size_id'],
                            'price' => $size['price'],
                            'sale_price' => $size['sale_price'] === '' ? null : $size['sale_price'],
                            'stock_qty' => $size['stock'],
                            'sale_start' => empty($size['sale_start']) ? null : $size['sale_start'],
                            'sale_end' => empty($size['sale_end']) ? null : $size['sale_end'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.inventory.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        $categories = Category::where('category_type', 0)->get(); // Main categories
        $subcategories = Category::where('category_type', 1)->get(); // Subcategories
        $subsubcategories = Category::where('category_type', 2)->get(); // Sub-subcategories
        $colors = Color::where('status', 'active')->get();
        $sizes = Size::where('status', 'active')->get();
        $variantRows = DB::table('product_variants')->where('inventory_id', $inventory->id)->get();

        $variants = [];
        foreach ($variantRows as $row) {
            $colorId = $row->color_id;
            if (!isset($variants[$colorId])) {
                $variants[$colorId] = [
                    'color_id' => $colorId,
                    'sizes' => []
                ];
            }
            $variants[$colorId]['sizes'][] = [
                'size_id' => $row->size_id,
                'price' => $row->price,
                'sale_price' => $row->sale_price,
                'stock' => $row->stock_qty,
                'sale_start' => $row->sale_start,
                'sale_end' => $row->sale_end,
                'priceError' => '',
                'salePriceError' => ''
            ];
        }
        $variants = array_values($variants);
        return view('admin.inventory.edit', compact(
            'inventory',
            'categories',
            'subcategories',
            'subsubcategories',
            'colors',
            'sizes',
            'variants'
        ));
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|unique:inventories,sku,' . $inventory->id,
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
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
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

        // Optionally update slug if name changed
        if ($inventory->name !== $data['name']) {
            $data['slug'] = $this->generateUniqueSlug($data['name']);
        }

        // Update the inventory
        $inventory->update($data);

        // Handle variants: remove old, insert new
        \DB::table('product_variants')->where('inventory_id', $inventory->id)->delete();

        $variants = json_decode($request->variants, true);

        if (is_array($variants)) {
            foreach ($variants as $variant) {
                if (isset($variant['sizes']) && is_array($variant['sizes'])) {
                    foreach ($variant['sizes'] as $size) {
                        \DB::table('product_variants')->insert([
                            'inventory_id' => $inventory->id,
                            'color_id' => $variant['color_id'],
                            'size_id' => $size['size_id'],
                            'price' => $size['price'],
                            'sale_price' => $size['sale_price'] === '' ? null : $size['sale_price'],
                            'stock_qty' => $size['stock'],
                            'sale_start' => empty($size['sale_start']) ? null : $size['sale_start'],
                            'sale_end' => empty($size['sale_end']) ? null : $size['sale_end'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.inventory.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
