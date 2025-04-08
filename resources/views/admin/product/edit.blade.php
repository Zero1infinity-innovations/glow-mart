@extends('admin.layouts.master')
@push('title')
Product Edit
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Product</h6>
    </div>
    <div class="col-6 text-end px-0 px-lg-3">
        <a href="{{route('admin.product.index')}}" class="btn btn-primary btn-sm px-3"><i
                class='bx bx-back'></i>Back</a>
    </div>
</div>
<hr />
<div class="card">

    <div class="card-body p-2">
        <h5 class="mb-4">Edit Product</h5>
        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="name" class="form-label">Name<span class="star">★</span></label>
                    <input type="text" name="product_name" id="product_name" value="{{ $product->product_name }}"
                        class="form-control" />
                    <div class="invalid-feedback name-error"> </div>
                </div>

                <div class="col-md-6 mt-3">
                    <label for="price" class="form-label">Sale Price<span class="star">★</span></label>
                    <input type="number" name="sale_price" id="sale_price" value="{{ $product->sale_price }}"
                        class="form-control" />
                    <div class="invalid-feedback price-error"> </div>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="price" class="form-label">MRP Price<span class="star">★</span></label>
                    <input type="number" name="mrp_price" id="mrp_price" value="{{ $product->mrp_price }}"
                        class="form-control" />
                    <div class="invalid-feedback price-error"> </div>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="price" class="form-label">Quantity<span class="star">★</span></label>
                    <input type="number" name="quantity" id="quantity" value="{{ $product->quantity }}"
                        class="form-control" />
                    <div class="invalid-feedback price-error"> </div>
                </div>

                <div class="image-preview">
                    <div class="row">
                        <div class="mb-3">
                            <label>Product Image</label>
                            <input type="file" name="product_image" id="productImageInput" class="form-control">
                            <div class="mt-2">
                                <img id="productImagePreview" src="{{ asset($product->product_image) }}" width="100">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Product Gallery</label>
                        <input type="file" name="product_gallery[]" id="productGalleryInput" class="form-control"
                            multiple>
                        <div id="galleryPreview" class="mt-2 d-flex flex-wrap">
                            @if($product->product_gallery)
                            @foreach(json_decode($product->product_gallery) as $galleryImage)
                            <img src="{{ asset($galleryImage) }}" width="80" class="m-1">
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="name" class="form-label">Category<span class="star">★</span></label>
                    <select name="category" class="form-control">
                        <option value="">Select Category</option>
                        @if($categories->count() > 0)
                        @foreach($categories as $category)
                        <option value="{{$category->id}}" {{ $product->category == $category->id ? 'selected' : '' }}>{{$category->category_name}}</option>
                        @endforeach
                        @endif
                    </select>
                    <div class="invalid-feedback category_id-error"> </div>
                </div>

                <div class="col-md-6 mt-3">
                    <label for="subcategory" class="form-label">Subcategory</label>
                    <select name="subcategory" id="subcategory" class="form-control">
                        <option value="">Select Subcategory</option>
                    </select>
                    <div class="invalid-feedback subcategory_id-error"></div>
                </div>

                <div class="col-md-6 mt-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="product_status" id="product_status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="1" {{ $product->product_status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $product->product_status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <div class="invalid-feedback status-error"> </div>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="status" class="form-label">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-control">
                        <option value="">Select Methoed</option>
                        <option value="cod_only" {{ $product->payment_method == 'cod_only' ? 'selected' : '' }}>COD Only
                        </option>
                        <option value="prepaid_only" {{ $product->payment_method == 'prepaid_only' ? 'selected' : '' }}>
                            Prepaid Only</option>
                    </select>
                    <div class="invalid-feedback status-error"> </div>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" value="" class="form-control" rows="5"
                        cols="5">{{ $product->description }}</textarea>
                    <div class="invalid-feedback description-error"> </div>
                </div>
                <div class="col-md-12 mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit </button>
                </div>
            </div>
        </form>
    </div>


</div>
@endsection
@push('script')
<script>
    $(document).ready(function() {
    var selectedCategory = "{{ $selectedCategoryId }}";
    var selectedSubcategory = "{{ $selectedSubcategoryId }}";

    function loadSubcategories(categoryId, selectedSubcategory) {
        if (categoryId) {
            $.ajax({
                url: '/get-subcategories',
                type: 'GET',
                data: { category_id: categoryId },
                success: function(response) {
                    $('#subcategory').empty().append('<option value="">Select Subcategory</option>');
                    $.each(response, function(index, subcategory) {
                        var isSelected = (subcategory.id == selectedSubcategory) ? 'selected' : '';
                        $('#subcategory').append('<option value="' + subcategory.id + '" ' + isSelected + '>' + subcategory.subcate_name + '</option>');
                    });
                }
            });
        } else {
            $('#subcategory').empty().append('<option value="">Select Subcategory</option>');
        }
    }

    // Load subcategories if category is already selected (Edit Case)
    if (selectedCategory) {
        loadSubcategories(selectedCategory, selectedSubcategory);
    }

    // Change event for dynamic selection
    $('#category').change(function() {
        var categoryId = $(this).val();
        loadSubcategories(categoryId, null);
    });
});
</script>
<script>

document.getElementById('productImageInput').addEventListener('change', function(event) {
    let reader = new FileReader();
    reader.onload = function() {
        document.getElementById('productImagePreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
});

document.getElementById('productGalleryInput').addEventListener('change', function(event) {
    let galleryPreview = document.getElementById('galleryPreview');
    galleryPreview.innerHTML = ""; // Clear previous images

    for (let file of event.target.files) {
        let reader = new FileReader();
        reader.onload = function() {
            let img = document.createElement('img');
            img.src = reader.result;
            img.width = 80;
            img.classList.add('m-1');
            galleryPreview.appendChild(img);
        }
        reader.readAsDataURL(file);
    }
});
</script>

@endpush