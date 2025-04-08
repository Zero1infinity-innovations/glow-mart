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
        <a href="{{route('admin.shops.index')}}" class="btn btn-primary btn-sm px-3"><i class='bx bx-back'></i>Back</a>
    </div>
</div>
<hr />
<div class="card">
    <div class="card-body p-2">
        <h5 class="mb-4">Edit Product</h5>
        <form action="{{ route('admin.shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <label for="shop_name" class="form-label">Shop Name</label>
                    <input type="text" name="shop_name" id="shop_name" value="{{ old('shop_name', $shop->shop_name) }}"
                        class="form-control @error('shop_name') is-invalid @enderror" />
                    @error('shop_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="owner_name" class="form-label">Owner Name</label>
                    <input type="text" name="owner_name" id="owner_name"
                        value="{{ old('owner_name', $shop->owner_name) }}"
                        class="form-control @error('owner_name') is-invalid @enderror" />
                    @error('owner_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mt-3">
                    <label for="owner_email" class="form-label">Owner Email</label>
                    <input type="email" name="owner_email" id="owner_email"
                        value="{{ old('owner_email', $shop->owner_email) }}"
                        class="form-control @error('owner_email') is-invalid @enderror" readonly/>
                    @error('owner_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mt-3">
                    <label for="mobile_no" class="form-label">Mobile Number</label>
                    <input type="text" name="mobile_no" id="mobile_no" value="{{ old('mobile_no', $shop->phone_number) }}"
                        class="form-control @error('mobile_no') is-invalid @enderror" />
                    @error('mobile_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mt-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $shop->city) }}"
                        class="form-control @error('city') is-invalid @enderror" />
                    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mt-3">
                    <label for="pincode" class="form-label">Pincode</label>
                    <input type="text" name="pincode" id="pincode" value="{{ old('pincode', $shop->pincode) }}"
                        class="form-control @error('pincode') is-invalid @enderror" />
                    @error('pincode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mt-3">
                    <label for="aadhar_number" class="form-label">Aadhar Number</label>
                    <input type="text" name="aadhar_number" id="aadhar_number"
                        value="{{ old('aadhar_number', $shop->aadhar_number) }}"
                        class="form-control @error('aadhar_number') is-invalid @enderror" />
                    @error('aadhar_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mt-3">
                    <label for="pan_number" class="form-label">Pan Number</label>
                    <input type="text" name="pan_number" id="pan_number"
                        value="{{ old('pan_number', $shop->pan_number) }}"
                        class="form-control @error('pan_number') is-invalid @enderror" />
                    @error('pan_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mt-3">
                    <label for="shop_status" class="form-label">Status</label>
                    <select name="shop_status" id="shop_status" class="form-control">
                        <option value="1" {{ $shop->shop_status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $shop->shop_status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('pan_number', $shop->address) }}"
                        placeholder="Enter Address" class="form-control @error('address') is-invalid @enderror" />
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mt-3">
                    <label for="shop_image" class="form-label">Shop Image</label>
                    <input type="file" name="shop_image" id="shop_image"
                        class="form-control @error('shop_image') is-invalid @enderror" />
                    @error('shop_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @if($shop->shop_image)
                    <img src="{{ asset($shop->shop_image) }}" width="100" class="mt-2">
                    @endif

                    <img id="shop_image_preview" src="#" alt="Shop Image Preview"
                        style="display:none; width: 150px; margin-top: 10px;">
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
document.getElementById('shop_image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('shop_image_preview').src = e.target.result;
            document.getElementById('shop_image_preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush