<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Subcategories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'category_id' => 'required|exists:categories,id',
        ]);

        $name = $request->input('name');
        $slug = Str::slug($name);

        $count = Categories::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        Subcategories::create([
            'name' => $name,
            'slug' => $slug,
            'category_id' => $request->input('category_id'),
        ]);

        return redirect('categories')->with('success', 'Child Category Added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subcategories = Subcategories::where('category_id', $id)->pluck('name', 'id');
        return response()->json($subcategories); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $subcategory = Subcategories::where('slug', $slug)->firstOrFail();
        return view('categories', compact('subcategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $subcategory = Subcategories::where('slug', $slug)->firstOrFail();
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $subcategory->id,
        ]);

        $name = $request->name;
        $slug = Str::slug($name);
        if ($subcategory->slug !== $slug) {
            $count = Categories::where('slug', $slug)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
        }

        // Update the category
        $subcategory->update([
            'name' => $name,
            'slug' => $slug,
        ]);
        return redirect('categories')->with('success', 'Sub Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $subcategory = Subcategories::where('slug', $slug)->firstOrFail();
        $subcategory->delete();
        return redirect('categories')->with('success', 'Sub Category deleted successfully.');
    }
}
