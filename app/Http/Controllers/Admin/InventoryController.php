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
        $categories = Category::all();
        $colors = Color::where('status', 'active')->get();
        $sizes = Size::where('status', 'active')->get();

        return view('admin.inventory.create', compact('categories', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|unique:inventories,sku',
            'main_image' => 'required|image',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'variants' => 'required|array',
        ]);

        // Upload main image
        $mainImage = null;
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image')->store('uploads/products/main', 'public');
        }

        // Upload gallery images
        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $image->store('uploads/products/gallery', 'public');
            }
        }

        // Extract color_ids and size_ids from variants
        $colorIds = [];
        $sizeIds = [];

        foreach ($request->variants as $variant) {
            $colorIds[] = $variant['color_id'];
            foreach ($variant['sizes'] as $size) {
                $sizeIds[] = $size['size_id'];
            }
        }

        // Remove duplicates
        $colorIds = array_values(array_unique($colorIds));
        $sizeIds = array_values(array_unique($sizeIds));

        // Save Inventory
        $inventory = new Inventory();
        $inventory->name = $request->name;
        $inventory->slug = \Str::slug($request->name);
        $inventory->sku = $request->sku;
        $inventory->category_id = $request->category_id;
        $inventory->short_description = $request->short_description;
        $inventory->full_description = $request->full_description;
        $inventory->main_image = $mainImage;
        $inventory->gallery_images = json_encode($galleryPaths);
        $inventory->fabric = $request->fabric;
        $inventory->fit = $request->Fit;
        $inventory->pattern = $request->Pattern;
        $inventory->top_length = $request->top_length;
        $inventory->meta_title = $request->meta_title;
        $inventory->meta_description = $request->meta_description;
        $inventory->meta_keywords = $request->meta_keywords;
        $inventory->status = $request->status ?? 'active';
        $inventory->is_featured = $request->is_featured == 'active' ? 1 : 0;
        $inventory->color_ids = json_encode($colorIds);
        $inventory->size_ids = json_encode($sizeIds);
        $inventory->save();

        // Store variants
        foreach ($request->variants as $variant) {
            foreach ($variant['sizes'] as $size) {
                \DB::table('product_variants')->insert([
                    'inventory_id' => $inventory->id,
                    'color_id' => $variant['color_id'],
                    'size_id' => $size['size_id'],
                    'price' => $size['price'],
                    'sale_price' => $size['sale_price'],
                    'stock_qty' => $size['stock'],
                    'sale_start' => $size['sale_start'] ?? null,
                    'sale_end' => $size['sale_end'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.inventory.index')->with('success', 'Product added successfully.');
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
