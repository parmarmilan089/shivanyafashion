<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // You can also paginate here
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'seller_name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,platform_sku',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,deactive',
            'selling_platform' => 'required|in:Amazon,Meesho',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        Product::create([
            'name' => $request->name,
            'seller_name' => $request->seller_name,
            'platform_sku' => $request->sku,
            'price' => $request->price,
            'status' => $request->status,
            'selling_platform' => $request->selling_platform,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    }

    // Edit method to show the edit form
    public function edit($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Return the view and pass the product to the view
        return view('admin.product.edit', compact('product'));
    }

    // Update method to save the edited product
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'seller_name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,platform_sku,' . $id,
            'price' => 'required|numeric',
            'status' => 'required|in:active,deactive',
            'selling_platform' => 'required|in:Amazon,Meesho',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update the product data
        $product->name = $request->input('name');
        $product->seller_name = $request->input('seller_name');
        $product->platform_sku = $request->input('sku');
        $product->price = $request->input('price');
        $product->status = $request->input('status');
        $product->selling_platform = $request->input('selling_platform');

        // Handle image upload if it's provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        // Save the updated product
        $product->save();

        // Redirect to the product list page with a success message
        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
    }

    public function delete($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete the image from storage if it exists
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        // Delete the product from the database
        $product->delete();

        // Redirect back to the product list page with a success message
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully');
    }

}
