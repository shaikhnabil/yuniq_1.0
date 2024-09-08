<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::with('subcategories')->latest()->paginate(10);
        return view('categories.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::with('subcategories')->latest()->get();
        return view('categories.create_category', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'image' => 'nullable|mimes:jpg,png,jpeg,webp|max:2048',
        ]);
        $name = $request->name;
        $slug = Str::slug($name);

        $count = Categories::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $imagePath = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('categories', $imageName, 'public');
        }

        Categories::create([
            'name' => $name,
            'slug' => $slug,
            'image' => $imagePath,
        ]);
        return redirect('categories')->with('success', 'Category Added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $category)
    {
        $subcategories = $category->with('subcategories')->get();
        return view('categories.edit_category', compact(['category','subcategories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categories $category)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,'.$category->id,
            'image' => 'nullable|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        $name = $request->name;
        $slug = Str::slug($name);
        if ($category->slug !== $slug) {
            $count = Categories::where('slug', $slug)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
        }

            // Handle image upload
            $imagePath = $category->image; // Keep the existing image path
            if ($request->hasFile('image')) {
                // Delete old image file if it exists
                if ($category->image && file_exists(public_path('storage/' . $category->image))) {
                    unlink(public_path('storage/' . $category->image));
                }

                // Store new image file
                $image = $request->file('image');
                $imageName = Str::slug($name) . '-' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('categories', $imageName, 'public');
            }

        // Update the category
        $category->update([
            'name' => $name,
            'slug' => $slug,
            'image' => $imagePath,
        ]);
        return redirect('categories')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $category)
    {
        $category->delete();
        return redirect('categories')->with('success', 'Category Deleted successfully.');
    }
}
