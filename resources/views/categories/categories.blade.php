@extends('admin.dashboard')
@push('title')
    Categories
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
    <div class="container mb-3">
        <a href="/create-category" class="btn btn-primary my-2 float-end">+</a>
    </div>
    <div class="container">
        @if (session('success'))
            <x-alert :msg="session('success')"></x-alert>
        @endif



        <table class="table table-bordered w-100 table-striped" id="dataTable">
            <thead class="table-light">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Image</th>
                    <th scope="col" class="text-center">Edit</th>
                    <th scope="col" class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $index => $category)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $category->name }}</strong>
                            @foreach ($category->subcategories as $subcategory)
                                <li class="ms-4 my-1">
                                    {{ $subcategory->name }}
                                    <a href="{{ route('subcategory.edit', $subcategory->slug) }}" class="text-warning fs-5"
                                        data-bs-toggle="modal" data-bs-target="#subcategory-{{ $subcategory->slug }}"><i
                                            class="bi bi-pencil-square"></i></a>
                                </li>

                                <!-- edit or delete sub category Modal -->
                                <div class="modal fade" id="subcategory-{{ $subcategory->slug }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Sub Category</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('subcategory.update', $subcategory->slug) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="name" name="name" value="{{ $subcategory->name }}">
                                                    </div>
                                                    @error('name')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                    <button type="submit" class="btn btn-primary col">Update</button>
                                                </form>
                                                <form action="{{ route('subcategory.delete', $subcategory->slug) }}"
                                                    method="post" class="float-end">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    width="80">
                            @else
                                No image
                            @endif
                        </td>
                        <td class="text-center"><a href="/category/edit/{{ $category->slug }}" class="btn btn-warning"><i
                                    class="bi bi-pencil-square"></i></a></td>
                        <td class="text-center">
                            <form action="{{ route('category.delete', $category->slug) }}" method="post"
                                class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="5">No Categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- {{ $categories->links() }} --}}
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            // Handle delete button click
            $('#dataTable').on('click', '.delete-form button[type="submit"]', function(e) {
                e.preventDefault(); // Prevent default form submission
                var form = $(this).closest('form');
                var actionUrl = form.attr('action');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });
            });
        })
    </script>

@endsection
