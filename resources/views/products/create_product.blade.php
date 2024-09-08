@extends('admin.dashboard')
@section('main')
@push('title') Create Products @endpush
    <!-- create product -->
    <div class="container my-3 rows">
        <div class="col-6  mx-auto border p-3 shadow rounded w-50 bg-white">
            <h3 class="text-center">Create Product</h3>
            <form action="{{route('products.create')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                </div>
                @error('name')<p class="text-danger">{{ $message }}</p>@enderror

                <div class="mb-3">
                    <label for="image" class="form-label">Images</label>
                    <input class="form-control @error('image.*') is-invalid @enderror" type="file" id="image" name="image[]" multiple>
                </div>
                @error('image.*')<p class="text-danger">{{ $message }}</p>@enderror

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                </div>
                @error('price')<p class="text-danger">{{ $message }}</p>@enderror

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" value="{{ old('description') }}"></textarea>
                </div>
                @error('description')<p class="text-danger">{{ $message }}</p>@enderror

                <div class="mb-3">
                    <label for="Category" class="form-label">Category</label>
                <select class="form-select @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" id="category">
                    <option selected disabled>Categories</option>
                    @foreach ($categories as $category)
                        <option value={{ $category->id }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                </div>
                @error('category')<p class="text-danger">{{ $message }}</p>@enderror

                <div class="mb-3">
                    <label for="subcategories" class="form-label">Sub categories (Sub category is populated on the basis of selected category)</label>
                    <select class="form-select @error('subcategory_ids') is-invalid @enderror" id="subcategories" name="subcategory_ids[]" multiple>
                        {{-- options will populated according to selected caategory --}}
                    </select>
                    @error('subcategory_ids') <p class="text-danger">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-2 ">Submit</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#category').change(function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: '/subcategories/' + categoryId,
                        type: 'GET',
                        success: function(data) {
                            $('#subcategories').empty();
                            // $('#subcategories').append('<option value="">Select Subcategory</option>');
                            $.each(data, function(key, value) {
                                $('#subcategories').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subcategories').empty(); // Clear subcategory dropdown if no category is selected
                }
            });
        });
        </script>
@endsection
