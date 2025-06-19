<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->get();
        return view('admin.color.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.color.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:colors,name',
            'code' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Color::create($request->only('name', 'code', 'status'));

        return redirect()->route('admin.color.index')->with('success', 'Color created successfully.');
    }

    public function edit(Color $color)
    {
        return view('admin.color.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|unique:colors,name,' . $color->id,
            'code' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $color->update($request->only('name', 'code', 'status'));

        return redirect()->route('admin.color.index')->with('success', 'Color updated successfully.');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('admin.color.index')->with('success', 'Color deleted.');
    }
}
