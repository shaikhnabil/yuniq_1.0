<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use App\Models\Subcategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with('category')->latest()->paginate(3);
        return view('home', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::select(['id', 'name'])->get();
        $subcategories = Subcategories::all();
        return view('products.create_product', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'image.*' => 'mimes:jpg,jpeg,png,webp|max:2048',
            'price' => 'required',
            'description' => 'required|string',
            'category' => 'nullable|exists:categories,id',
            'subcategory_ids' => 'nullable|array|exists:subcategories,id',
            'subcategory_ids.*' => 'nullable|exists:subcategories,id',
        ], [
            'image.*.mimes' => 'Only jpeg, jpg, png, and webp images are allowed.',
            'image.*.max' => 'Each image may not be greater than 2 MB.',
        ]);


        $imagePaths = [];
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $index => $image) {
                $imageName = Str::slug($request->name) . '-' . ($index + 1) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $imagePaths[] = $imagePath;
            }
        }


        $slug = Str::slug($request->name);
        $existProdCount = Products::where('slug', $slug)->count();
        if ($existProdCount > 0) {
            $slug .= '-' . ($existProdCount + 1);
        }

        $product = Products::create([
            'name' => $request->name,
            'image' => json_encode($imagePaths),
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category,
            'slug' => $slug
        ]);
        // Attach subcategories to the product
        if ($request->has('subcategory_ids')) {
            $product->subcategories()->sync($request->input('subcategory_ids'));
        }

        return redirect('products')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $product = Products::where('slug', $slug)->firstOrFail();
        return view('products.view_product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $product = Products::where('slug', $slug)
            ->with('category', 'subcategories')
            ->firstOrFail();

        $categories = Categories::select(['id', 'name'])->get();

        $selectedCategoryId = $product->category_id;
        $subcategories = $selectedCategoryId ? Categories::find($selectedCategoryId)->subcategories : [];

        return view('products.edit_product', compact(['product', 'categories', 'subcategories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $product = Products::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:100',
            'image.*' => 'mimes:jpg,jpeg,png,webp|max:2048',
            'price' => 'required',
            'description' => 'required|string',
            'category' => 'required|exists:categories,id',
            'subcategory_ids' => 'array',
            'subcategory_ids.*' => 'exists:subcategories,id',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->category_id = $request->category;

        if ($request->hasFile('image')) {
            // Delete old images if they exist
            if ($product->image) {
                $oldImages = json_decode($product->image);

                foreach ($oldImages as $oldImage) {
                    if (Storage::exists('public/' . $oldImage)) {
                        Storage::delete('public/' . $oldImage);
                    }
                }
            }

            $imagePaths = [];
            $images = $request->file('image');
            foreach ($images as $index => $image) {
                $imageName = Str::slug($request->name) . '-' . ($index + 1) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $imagePaths[] = $imagePath;
            }
            $product->image = json_encode($imagePaths);
        }


        $slug = Str::slug($product->name);
        $existProdCount = Products::where('slug', $slug)->count();
        if ($existProdCount > 0) {
            $slug .= '-' . ($existProdCount + 1);
        }
        $product->slug = $slug;
        $product->save();
        $product->subcategories()->sync($request->subcategory_ids);
        return redirect('products')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $product = Products::where('slug', $slug)->firstOrFail();
        $product->delete();
        return redirect('products')->with('success', 'Product Trashed successfully.');
    }

    public function products(Request $request)
    {
        if ($request->ajax()) {
            $products = Products::with('category', 'subcategories')->get();
            return DataTables::of($products)
                ->addColumn('image', function ($product) {
                    $images = $product->image ? json_decode($product->image) : [];
                    $firstImage = !empty($images) ? $images[0] : 'products/default.png';
                    return '<img src="' . asset('storage/' . $firstImage) . '" class="product-image" style="width: 100px; height: auto; object-fit: cover;">';
                })
                ->addColumn('description', function ($product) {
                    return Str::words($product->description, 12) .
                    ' <button class="btn btn-light btn-sm view-description" data-description="' .
                     htmlspecialchars($product->description) . '"><i class="bi bi-box-arrow-up-right"></i></button>';
                })
                ->addcolumn('price', function($product){
                    return '₹'.number_format($product->price, 2);
                })
                // ->addColumn('description', function ($product) {
                //     return Str::words($product->description, 12);
                // })
                ->addColumn('category', function ($product) {
                    return $product->category->name ?? '';
                })
                ->addColumn('subcategories', function ($product) {
                    return $product->subcategories->map(function ($subcategory) {
                        return '<span class="badge bg-secondary">' . $subcategory->name . '</span>';
                    })->implode(' ');
                })
                ->addColumn('actions', function ($product) {
                    return '
                <a href="' . route('products.show', $product->slug) . '" class="btn btn-primary"><i class="bi bi-eye-fill"></i></a>
                <a href="' . route('products.edit', $product->slug) . '" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                <form action="' . route('products.destroy', $product->slug) . '" method="post" class="d-inline delete-form">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                </form>
            ';
                })
                ->rawColumns(['image', 'description', 'subcategories', 'actions'])
                ->make(true);
        }

        // dd('hello');
        return view('products.products');
    }



    public function trashed_products()
    {
        $products = Products::onlyTrashed()->with('category')->paginate(3);
        return view('products.trashed_products', compact('products'));
    }

    public function restore(string $slug)
    {
        $product = Products::withTrashed()->where('slug', $slug)->firstOrFail();
        $product->restore();
        return redirect('products')->with('success', 'Product Restored successfully.');
    }

    public function force_delete(string $slug)
    {
        $product = Products::withTrashed()->where('slug', $slug)->firstOrFail();
        if ($product->image) {
            $images = json_decode($product->image);
            foreach ($images as $image) {
                Storage::delete('public/' . $image);
            }
        }
        $product->forceDelete();
        return redirect('trashed_products')->with('success', 'Product Deleted successfully.');
    }
}
