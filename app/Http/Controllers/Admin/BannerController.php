<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp',
        ]);

        // Store the image in storage/app/public/banners
        $imagePath = $request->file('image')->store('banners', 'public');

        // Create banner
        Banner::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        // Redirect with success message
        return redirect()->route('admin.banner.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        // Validate input fields
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ]);

        // Find the banner
        $banner = Banner::findOrFail($id);

        // Update basic fields
        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->status = $request->status;

        // Handle image upload if new image provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($banner->image && Storage::exists('public/' . $banner->image)) {
                Storage::delete('public/' . $banner->image);
            }

            // Store new image
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        // Save changes
        $banner->save();

        return redirect()->route('admin.banner.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->image);
        $banner->delete();
        return back()->with('success', 'Banner deleted.');
    }
}
