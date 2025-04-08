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
        <h5 class="mb-4">Add Sub Category</h5>
        <form action="{{ route('admin.sub-category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <label for="sub_category_name" class="form-label">Sub Category Name</label>
                    <input type="text" name="sub_category_name" id="sub_category_name" value="{{ old('sub_category_name') }}"
                        placeholder="Enter Sub Category Name"
                        class="form-control @error('sub_category_name') is-invalid @enderror" />
                    @error('sub_category_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mt-3">
                    <label for="parent_category" class="form-label">Parent Category</label>
                    <select name="parent_category" id="parent_category"
                        class="form-control @error('parent_category') is-invalid @enderror">
                        <option value="">Select Parent Category</option>
                        @foreach($parentCates as $parentCate)
                        <option value="{{ $parentCate->id }}"
                            {{ old('parent_category') == $parentCate->id ? 'selected' : '' }}>
                            {{ $parentCate->category_name }}
                        </option>
                        @endforeach
                    </select>

                    @error('parent_category')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mt-3">
                    <label for="sub_discription" class="form-label">Discripction</label>
                    <input type="text" name="sub_discription" id="sub_discription" value="{{ old('discription') }}"
                        placeholder="Enter Discription"
                        class="form-control @error('sub_discription') is-invalid @enderror" />
                    @error('sub_discription')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mt-3">
                    <label for="sub_category_image" class="form-label">Sub Catregory Image</label>
                    <input type="file" name="sub_category_image" id="sub_category_image"
                        class="form-control @error('sub_category_image') is-invalid @enderror" />
                    <img id="category_image_preview" src="#" alt="Catregory Image Preview"
                        style="display:none; width: 150px; margin-top: 10px;">
                    @error('sub_category_image')
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