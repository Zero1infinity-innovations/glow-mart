@extends('admin.layouts.master')
@push('title')
    Product List
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Product</h6>
    </div>
    <div class="col-6 text-end px-0 px-lg-3">
        <a href="{{route('admin.product.index')}}" class="btn btn-primary btn-sm px-3"><i class='bx bx-back'></i>Back</a>
    </div>
</div>
<hr />
<div class="card">

    <div class="card-body p-2">
        <h5 class="mb-4">Add Product</h5>
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="name" class="form-label">Name<span class="star">★</span></label>
                    <input type="text" name="product_name" require id="product_name" class="form-control" />
                    <div class="invalid-feedback name-error"> </div>
                </div>
                
                <div class="col-md-6 mt-3">
                    <label for="price" class="form-label">Sale Price<span class="star">★</span></label>
                    <input type="number" name="sale_price" require id="sale_price" class="form-control" />
                    <div class="invalid-feedback price-error"> </div>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="price" class="form-label">MRP Price<span class="star">★</span></label>
                    <input type="number" name="mrp_price" require id="mrp_price" class="form-control" />
                    <div class="invalid-feedback price-error"> </div>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="price" class="form-label">Quantity<span class="star">★</span></label>
                    <input type="number" name="quantity" require id="quantity"   class="form-control" />
                    <div class="invalid-feedback price-error"> </div>
                </div>
            
                <div class="col-md-6 mt-3">
                    <label for="image" class="form-label">Product Image<span class="star">★</span></label>
                    <input type="file" name="product_image" require id="product_image"   class="form-control" />
                    <div class="invalid-feedback image-error"> </div>

                    <img id="product_image_preview" src="#" alt="Product Image Preview" style="display:none; width: 150px; margin-top: 10px;">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="multi_image" class="form-label">Multiple Image</label>
                    <input type="file" name="product_gallery[]" id="product_gallery" class="form-control" multiple />
                    <div class="invalid-feedback multi_image-error"> </div>
                    <div id="product_gallery_preview"></div>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="name" class="form-label">Category</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Select Category</option>
                        @if($categories->count() > 0)
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
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
                    <select name="product_status" id="product_status" class="form-control"  >
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <div class="invalid-feedback status-error"> </div>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="status" class="form-label">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-control"  >
                        <option value="">Select Methoed</option>
                        <option value="cod_only">COD Only</option>
                        <option value="prepaid_only">Prepaid Only</option>
                    </select>
                    <div class="invalid-feedback status-error"> </div>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea  name="description" id="description" class="form-control" rows="5" cols="5"></textarea>
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
    $('#category').change(function() {
        var categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                url: '/get-subcategories',
                type: 'GET',
                data: { category_id: categoryId },
                success: function(response) {
                    $('#subcategory').empty().append('<option value="">Select Subcategory</option>');
                    $.each(response, function(index, subcategory) {
                        $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.subcate_name + '</option>');
                    });
                }
            });
        } else {
            $('#subcategory').empty().append('<option value="">Select Subcategory</option>');
        }
    });
});

    document.getElementById('product_image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('product_image_preview').src = e.target.result;
            document.getElementById('product_image_preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('product_gallery').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('product_gallery_preview');
    previewContainer.innerHTML = ""; // Clear previous previews

    for (const file of event.target.files) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = "100px";
            img.style.marginRight = "10px";
            previewContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
