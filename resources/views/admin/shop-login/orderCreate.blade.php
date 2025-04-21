@extends('admin.layouts.master')

@push('title')
    Add Stock
@endpush

@section('content')
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-6">
            <h6 class="mb-0 text-uppercase">Create Order</h6>
        </div>
        <div class="col-6 text-end px-0 px-lg-3">
            <a href="{{ route('admin.shop.order.list') }}" class="btn btn-primary btn-sm px-3">
                <i class='bx bx-left-arrow'></i> Back
            </a>
        </div>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <form action="" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col-sm-3 mb-2">
                        <label for="username">Name</label>
                        <select class="form-control select2" id="nameSelect">
                            <option value="">-- Select Name --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                            <option value="Other">Other</option>
                        </select>
                        <div class="row mt-2" id="otherNameField" style="display: none;">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="otherName" placeholder="Enter your name">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label> Product </label>
                        <select name="product_id" class="form-control" id="product-select">
                            <option value="">Select Product</option>
                            @foreach ($products as $item)
                                <option value="{{ $item->id }}" data-qty="{{ $item->quantity ?? 0 }}">
                                    {{ $item->product_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br />
                <label>Quantity</label>
                <input type="text" name="qty" id="qty-input" class="form-control" /><br />
                <label> Select Shop(s) </label>
                <select name="shop_ids[]" class="form-control" id="shop-select" multiple>
                </select><br />

                <input type="submit" class="btn btn-primary btn-sm" value="Submit">
            </form>

        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select or search name"
            });

            // Toggle input field
            $('#nameSelect').on('change', function() {
                if ($(this).val() === 'Other') {
                    $('#otherNameField').slideDown();
                } else {
                    $('#otherNameField').slideUp();
                }
            });
        });
    </script>
@endpush
