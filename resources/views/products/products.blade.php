@extends('admin.dashboard')

@push('title')
    Products
@endpush
@section('css')
    <style>
        table td:last-child {
            white-space: nowrap;
        }

        div.dataTables_wrapper div.dataTables_length select {
            width: 50%;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            margin: 0;
            padding: 0;
        }
    </style>
@endsection

@section('main')
    <!-- Product description Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="productDescription"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="post" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="container alert-container my-4">
        @if (session('success'))
            <x-alert :msg="session('success')"></x-alert>
        @endif

        <h3 class="text-center mb">Products</h3>
        <a href="{{ route('products.create') }}" class="btn btn-primary text-center my-1 mx-2 float-end">+</a>
        <a href="{{ route('products.trashed') }}" class="btn btn-light text-danger border border-danger float-end my-1">
            <i class="bi bi-trash-fill"> Products</i>
        </a>

        <table class="table table-bordered table-striped" id="productTable">
            <thead>
                <tr>
                    <th>Images</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th style="white-space: nowrap;">Actions</th>
                </tr>
            </thead>
        </table>

    </div>

    <script>
        $(document).ready(function() {
            //getting products
            $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('products') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        orderable: false,
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'subcategories',
                        name: 'subcategories',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            //display description modal
            $('#productTable tbody').on('click', '.view-description', function() {
                var description = $(this).data('description');
                $('#productDescription').text(description);
                var myModal = new bootstrap.Modal(document.getElementById('productModal'));
                myModal.show();
            });

            // Handle delete button click
            $('#productTable tbody').on('click', '.delete-form button[type="submit"]', function(e) {
                e.preventDefault(); // Prevent default form submission
                var form = $(this).closest('form');
                var actionUrl = form.attr('action');
                $('#deleteForm').attr('action', actionUrl);
                var myModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
                myModal.show();
            });

            // Handle delete confirmation
            $('#deleteForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        $('#deleteConfirmationModal').modal('hide');
                        $('#productTable').DataTable().ajax.reload(); // Reload table data

                        // Manually create and append the success alert
                        var alertHtml =
                            '<div class="alert alert-success alert-dismissible my-2 fade show" role="alert">' +
                            '<strong>Product Trashed successfully.</strong>' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>';
                        $('.alert-container').prepend(alertHtml);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection



{{-- @extends('admin.dashboard')
@section('main')
@push('title') Products @endpush

<div class="container my-4">
    @if (session('success'))
        <x-alert :msg="session('success')"></x-alert>
    @endif

    <h3 class="text-center mb">Products</h3>
    <a href="{{ route('products.create') }}" class="btn btn-primary text-center my-1 mx-2 float-end">+</a>
    <a href="{{ route('products.trashed') }}" class="btn btn-light text-danger border border-danger float-end my-1">
        <i class="bi bi-trash-fill"> Products</i>
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Images</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th colspan="3">Actions</th>
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
                            <img src="{{ asset('storage/' . $firstImage) }}" class="product-image" alt="Product Image" style="width: 100px; height: auto; object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/products/default.png') }}" class="product-image" alt="Default Product Image" style="width: 100px; height: auto; object-fit: cover;">
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ Str::words($product->description, 12, '...') }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->category->name ?? '' }}</td>
                    <td>
                        @foreach ($product->subcategories as $subcategory)
                            <span class="badge bg-secondary">{{ $subcategory->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary"><i class="bi bi-eye-fill"></i></a>
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->slug) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                    </td>
                    <td>
                        <form action="{{ route('products.destroy', $product->slug) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
</div>
@endsection --}}
