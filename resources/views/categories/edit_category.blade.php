@extends('admin.dashboard')
@section('main')
@push('title') Edit Category @endpush
    <!-- create Category position-absolute top-50 start-50 translate-middle-->
    <div class="container my-5">
        <div class="row">
            <div class=" border p-3 shadow rounded bg-white">
                <h3 class="text-center">Update Category</h3>
                <form action="{{ route('category.update', $category->slug) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ $category->name }}">
                    </div>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                            name="image">
                        @if ($category->image)
                            <div class="card-img-container d-flex overflow-x-auto">
                                <img src="{{ asset('storage/' . $category->image) }}" class="card-img mx-2 my-2 border"
                                    alt="Product Image" style="width:40px;height:30px;">
                            </div>
                        @endif
                    </div>
                    @error('image')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
