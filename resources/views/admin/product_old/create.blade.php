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
        <form class="row g-3" id="productForm" enctype="multipart/form-data">
            @csrf
            <div class="col-md-4">
                <label for="name" class="form-label">Name<span class="star">★</span></label>
                <input type="text" name="name" id="name" class="form-control" />
                <div class="invalid-feedback name-error"> </div>
            </div>
            <div class="col-md-4">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" id="description" class="form-control" />
                <div class="invalid-feedback description-error"> </div>
            </div>
            <div class="col-md-4">
                <label for="price" class="form-label">Unit Per Price<span class="star">★</span></label>
                <input type="text" name="price" id="price" class="form-control" />
                <div class="invalid-feedback price-error"> </div>
            </div>
            <div class="col-md-4">
                <label for="unit" class="form-label">Unit<span class="star">★</span></label>
                <select name="unit" id="unit" class="form-control">
                    <option selected value="">Select Unit</option>
                    <option value="Quantity">Quantity</option>
                    <option value="Gram">Gram</option>
                    <option value="Kilogram">Kilogram</option>
                    <option value="Milliliter">Milliliter</option>
                    <option value="Liter">Liter</option>
                </select>
                <div class="invalid-feedback unit-error"> </div>
            </div>
            <div class="col-md-4">
                <label for="image" class="form-label">Main Image<span class="star">★</span></label>
                <input type="file" name="image" id="image" class="form-control" />
                <div class="invalid-feedback image-error"> </div>
            </div>
            <div class="col-md-4">
                <label for="multi_image" class="form-label">Multiple Image</label>
                <input type="file" name="multi_image[]" id="multi_image" class="form-control" multiple />
                <div class="invalid-feedback multi_image-error"> </div>
            </div>
            <div class="col-md-4">
                <label for="name" class="form-label">Category<span class="star">★</span></label>
                    @if($categories->count() > 0)
                    <select name="category_id">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                    @endif
                </select>
                <div class="invalid-feedback category_id-error"> </div>
            </div>
            <div class="col-md-4">
                <label for="seo_title" class="form-label">SEO Title</label>
                <input type="text" name="seo_title" id="seo_title" class="form-control" />
                <div class="invalid-feedback seo_title-error"> </div>
            </div>
            <div class="col-md-4">
                <label for="seo_description" class="form-label">SEO Description</label>
                <textarea name="seo_description" id="seo_description" rows="3" class="form-control"></textarea>
                <div class="invalid-feedback seo_description-error"> </div>
            </div>
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <div class="invalid-feedback status-error"> </div>
            </div>
            <div class="col-md-12 mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit </button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('script')
<script>
    productForm.onsubmit = async (e) =>{
        e.preventDefault();
        makePostRequest("{{route('admin.product.store')}}",productForm,'productForm')
    }
</script>
@endpush
