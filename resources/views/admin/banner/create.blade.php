@extends('admin.layouts.master')
@push('title')
    Banner List
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Banner</h6>
    </div>
    <div class="col-6 text-end px-0 px-lg-3">
        <a href="{{route('admin.banner.index')}}" class="btn btn-primary btn-sm px-3"><i class='bx bx-back'></i>Back</a>
    </div>
</div>
<hr />
<div class="card">

    <div class="card-body p-2">
        <h5 class="mb-4">Add Banner</h5>
        <form class="row g-3" id="categoryForm">
            @csrf
            <div class="col-md-4">
                <label for="banner_type" class="form-label">Banner Type<span class="star">★</span></label>
                <select name="banner_type" id="banner_type" class="form-control">
                    <option value="">Select Banner Type</option>
                    <option value="mobile">Mobile</option>
                    <option value="desktop">Desktop</option>
                </select>
                <div class="invalid-feedback banner_type-error"> </div>
            </div>

            <div class="col-md-4">
                <label for="banner" class="form-label">Banner Image</label>
                <input type="file" name="banner_image" id="banner_image" class="form-control" />
                <div class="invalid-feedback banner_image-error"> </div>
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
        makePostRequest("{{route('admin.banner.store')}}",categoryForm,'categoryForm')
    }
</script>
@endpush
