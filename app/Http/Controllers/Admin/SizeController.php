<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->get();
        return view('admin.size.index', compact('sizes'));
    }

    public function create()
    {
        return view('admin.size.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:sizes,name',
            'status' => 'required|in:active,inactive',
        ]);

        Size::create($request->only('name', 'status'));

        return redirect()->route('admin.size.index')->with('success', 'Size added successfully.');
    }

    public function edit(Size    $size)
    {
        return view('admin.size.edit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:sizes,name,' . $size->id,
            'status' => 'required|in:active,inactive',
        ]);

        $size->update($request->only('name', 'status'));

        return redirect()->route('admin.size.index')->with('success', 'Size updated successfully.');
    }

    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('admin.size.index')->with('success', 'Size deleted.');
    }
}
