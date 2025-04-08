@extends('admin.layouts.master')
@push('title')
Product List
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Category</h6>
    </div>
    <div class="col-6 text-end px-0 px-lg-3">
        <a href="{{route('admin.category.index')}}" class="btn btn-primary btn-sm px-3"><i
                class='bx bx-back'></i>Back</a>
    </div>
</div>
<hr />
<div class="card">

    <div class="card-body p-2">
        <h5 class="mb-4">Add Category</h5>
        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" name="category_name" id="category_name" value="{{ old('category_name') }}"
                        placeholder="Enter Category Name" class="form-control @error('category_name') is-invalid @enderror" />
                    @error('category_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mt-3">
                    <label for="discription" class="form-label">Discripction</label>
                    <input type="text" name="discription" id="discription" value="{{ old('discription') }}"
                        placeholder="Enter Discription" class="form-control @error('discription') is-invalid @enderror" />
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mt-3">
                    <label for="category_image" class="form-label">Catregory Image</label>
                    <input type="file" name="category_image" id="category_image"
                        class="form-control @error('category_image') is-invalid @enderror" />
                    <img id="category_image_preview" src="#" alt="Catregory Image Preview"
                        style="display:none; width: 150px; margin-top: 10px;">
                    @error('category_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
document.getElementById('category_image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('category_image_preview').src = e.target.result;
            document.getElementById('category_image_preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush