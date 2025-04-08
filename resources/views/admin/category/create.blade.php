@extends('admin.layouts.master')
@push('title')
    Category List
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Category</h6>
    </div>
    <div class="col-6 text-end px-0 px-lg-3">
        <a href="{{route('admin.category.index')}}" class="btn btn-primary btn-sm px-3"><i class='bx bx-back'></i>Back</a>
    </div>
</div>
<hr />
<div class="card">

    <div class="card-body p-2">
        <h5 class="mb-4">Add Category</h5>
        <form class="row g-3" id="categoryForm">
            @csrf
            <div class="col-md-4">
                <label for="category_name" class="form-label">Category Name<span class="star">★</span></label>
                <input type="text" name="category_name" id="category_name" class="form-control" />
                <div class="invalid-feedback category_name-error"> </div>
            </div>

            <div class="col-md-4">
                <label for="category_image" class="form-label">Category Image</label>
                <input type="file" name="category_image" id="category_image" class="form-control" />
                <div class="invalid-feedback category_image-error"> </div>
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
                <label for="gmc_category" class="form-label">GMC Category</label>
                <input type="text" name="gmc_category" id="gmc_category" class="form-control" />
                <div class="invalid-feedback gmc_category-error"> </div>
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
    categoryForm.onsubmit = async (e) =>{
        e.preventDefault();
        makePostRequest("{{route('admin.category.store')}}",categoryForm,'categoryForm')
    }
</script>
@endpush
