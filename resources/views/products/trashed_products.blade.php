@extends('admin.dashboard')
@section('main')
    @push('title')
        Trashed Products
    @endpush
    <div class="container my-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Images</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->isEmpty())
                    <tr class="text-center">
                        <td colspan="7">No products found.</td>
                    </tr>
                @endif
                @foreach ($products as $product)
                    <tr>
                        <td>
                            @php
                                $images = $product->image ? json_decode($product->image) : [];
                            @endphp
                            @if (!empty($images))
                                @php
                                    $firstImage = $images[0]; // Use the first image
                                @endphp
                                <img src="{{ asset('storage/' . $firstImage) }}" class="product-image" alt="Product Image"
                                    style="width: 100px; height: auto; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/products/default.png') }}" class="product-image"
                                    alt="Default Product Image" style="width: 100px; height: auto; object-fit: cover;">
                            @endif

                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ Str::words($product->description, 12, '...') }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            @foreach ($product->subcategories as $subcategory)
                                <span class="badge bg-secondary">{{ $subcategory->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('products.restore', $product->slug) }}"
                                class="btn btn-warning btn-sm">Restore</a>
                        </td>
                        <td>
                            <form action="{{ route('products.force_delete', $product->slug) }}" method="post"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            {{ $products->links() }}
        </table>
    </div>
@endsection
