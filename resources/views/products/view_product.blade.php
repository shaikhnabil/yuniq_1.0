@extends('layouts.main')
@push('title')
    Product Details
@endpush

@section('css')
<style>
.quantity-input {
    width: 80px !important;
    text-align: center;
}
.card-img-container {
    display: flex;
    overflow-x: auto;
    gap: 10px;
}
.card-img {
    flex-shrink: 0;
}
.product-image {
    object-fit: cover;
    width: 100%;
    height: auto;
}
</style>
@endsection

@section('main')
    @if (session('success'))
        <x-alert :msg="session('success')"></x-alert>
    @endif
    <div class="container my-3">
        <div class="card mx-auto border p-3 shadow rounded bg-white">
            @php
                $images = $product->image ? json_decode($product->image) : [];
            @endphp
            @if (!empty($images))
                <div class="card-img-container">
                    @foreach ($images as $image)
                        <img src="{{ asset('storage/' . $image) }}" class="card-img border p-2" alt="Product Image" style="width:100%; max-width: 400px; height:auto;">
                    @endforeach
                </div>
            @else
                <img src="{{ asset('storage/products/default.png') }}" class="product-image" alt="Default Product Image">
            @endif
            <hr>
            <div class="card-body">
                <h3 class="card-title mb-4">{{ $product->name }}</h3>
                <p class="card-text mb-0"><span class="fw-bold">Description: </span>{{ $product->description }}</p>
                <p class="card-text mb-0"><span class="fw-bold">Price: </span>₹{{ number_format($product->price, 2) }}</p>
                <p class="card-text mb-0"><span class="fw-bold">Category: </span>{{ $product->category->name ?? 'None' }}</p>
                <p class="card-text">
                    <span class="fw-bold">Sub Categories: </span>
                    @foreach ($product->subcategories as $subcategory)
                        <span class="badge bg-secondary">{{ $subcategory->name }}</span>
                    @endforeach
                </p>

                <!-- Quantity and Add/Remove Cart Buttons -->
                <div class="container px-0">
                    <div class="row justify-content-end mb-3">
                        @if (session('cart') && array_key_exists($product->id, session('cart')))
                            <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="bi bi-cart-x"> Remove From Cart</i></button>
                            </form>
                        @else
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <input type="number" name="quantity" class="form-control quantity-input me-2" value="1" min="1">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-cart-plus"> Add To Cart</i></button>
                            </form>
                        @endif
                    </div>
                    <form class="text-center" action="{{ route('checkout.direct', $product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-dark"><i class="bi bi-cart-check"> Buy Now</i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
