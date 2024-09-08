@extends('admin.dashboard')
@section('main')
@push('title') Update Product @endpush
    <!-- create product -->
    <div class="container my-3 rows">
        <div class="col-6  mx-auto border p-3 shadow rounded w-50 bg-white">
            <h3 class="text-center">Edit Product</h3>
            <form action="{{ route('products.update', $product->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ $product->name }}">
                </div>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="mb-3">
                    <label for="image" class="form-label">Images</label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                        name="image[]" multiple>
                    @if ($product->image)
                        @php
                            $images = json_decode($product->image);
                        @endphp
                        <div class="card-img-container d-flex overflow-x-auto">
                            @foreach ($images as $image)
                                <img src="{{ asset('storage/' . $image) }}" class="card-img mx-2 my-2 border"
                                    alt="Product Image" style="width:40px;height:30px;">
                            @endforeach
                        </div>
                    @endif
                </div>
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                        name="price" value="{{ $product->price }}">
                </div>
                @error('price')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3">{{ $product->description }}</textarea>
                </div>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select @error('category') is-invalid @enderror" name="category" id="category">
                        <option selected disabled>Select a Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ isset($product->category) && $product->category->id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subcategories -->
                <div class="mb-3">
                    <label for="subcategories" class="form-label">Sub categories</label>
                    <select class="form-select @error('subcategory_ids') is-invalid @enderror" id="subcategories" name="subcategory_ids[]" multiple>

                    </select>
                    @error('subcategory_ids') <p class="text-danger">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-2 ">Update</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            populateSubcategories('{{ $product->category_id }}', @json($product->subcategories->pluck('id')->toArray()));


            $('#category').change(function() {
                var categoryId = $(this).val();
                populateSubcategories(categoryId, []);
            });


            function populateSubcategories(categoryId, selectedSubcategories) {
                if (categoryId) {
                    $.ajax({
                        url: '/subcategories/' + categoryId,
                        type: 'GET',
                        success: function(data) {
                            $('#subcategories').empty();
                            $.each(data, function(key, value) {
                                var isSelected = selectedSubcategories.includes(parseInt(key)) ? 'selected' : '';
                                $('#subcategories').append('<option value="' + key + '" ' + isSelected + '>' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subcategories').empty();
                }
            }
        });
    </script>
@endsection
