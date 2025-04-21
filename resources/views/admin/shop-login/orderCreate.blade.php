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
            <form action="{{ route('admin.shop.order.store') }}" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col-sm-12 mb-2">
                        <label for="username">Name</label>
                        <select class="form-control select2" id="nameSelect" name="user_id">
                            <option value="">-- Select Name --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                            <option value="Other">Other</option>
                        </select>
                        <div class="row mt-2" id="otherNameField" style="display: none;">
                            <div class="col-sm-12">
                                <input type="text" name="otherName" class="form-control" id="otherName" placeholder="Enter your name">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="product-variant-wrapper">
                    <div class="row product-variant-row">
                        <div class="col-sm-3">
                            <label> Product </label>
                            <select name="product_id[]" class="form-control select2 product-select">
                                <option value="">Select Product</option>
                                @foreach ($products as $item)
                                    <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label> Product Variant </label>
                            <select name="sku[]" class="form-control select2 varince-select">
                                <option value="">Select Variant</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label>Price</label>
                            <input type="number" name="price[]" class="form-control variant-price" readonly />
                        </div>
                        <div class="col-sm-2">
                            <label>Quantity</label>
                            <input type="text" name="qty" id="qty-input" class="form-control" /><br />
                        </div>
                        <div class="col-sm-2 mt-4">
                            <button type="button" class="btn btn-primary add-more-btn"><i class="bx bx-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <label>Discount</label>
                        <input type="number" name="discount" id="discount" class="form-control" /><br />
                    </div>
                    <div class="col-sm-4">
                        <label>Tax</label>
                        <input type="number" name="tax" id="tax-input" class="form-control" /><br />
                    </div>
                </div>
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

            $(document).on('change', '.product-select', function() {
                const $row = $(this).closest('.product-variant-row');
                const productId = $(this).val();
                const $variantSelect = $row.find('.varince-select');

                const url = '{{ route('admin.shops.getProductVarince', ':id') }}'.replace(':id', productId);

                if (productId) {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            $variantSelect.empty().append(
                                '<option value="">Select Variant</option>');
                            response.variants.forEach(variant => {
                                $variantSelect.append(
                                    `<option value="${variant.sku}" data-price="${variant.price}">${variant.size}</option>`
                                );
                            });
                        }
                    });
                }
            });

            // Variant change => set price
            $(document).on('change', '.varince-select', function() {
                const $row = $(this).closest('.product-variant-row');
                const selected = $(this).find('option:selected');
                const price = selected.data('price') || 0;
                $row.find('.variant-price').val(price);
            });

            // Add new row
            $(document).on('click', '.add-more-btn', function() {
                const newRow = `
        <div class="row product-variant-row mt-2">
            <div class="col-sm-3">
                <label> Product </label>
                <select name="product_id[]" class="form-control select2 product-select">
                    <option value="">Select Product</option>
                    @foreach ($products as $item)
                        <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                <label> Product Variant </label>
                <select name="sku[]" class="form-control select2 varince-select">
                    <option value="">Select Variant</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label>Price</label>
                <input type="number" name="price[]" class="form-control variant-price" readonly />
            </div>
            <div class="col-sm-2">
                <label>Quantity</label>
                <input type="text" name="qty" id="qty-input" class="form-control" /><br />
            </div>
            <div class="col-sm-2 mt-4">
                <button type="button" class="btn btn-danger remove-row"><i class="bx bx-trash"></i></button>
            </div>
        </div>
        `;
                $('#product-variant-wrapper').append(newRow);
                $('.select2').select2(); // reinitialize Select2
            });

            // Remove row if needed
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.product-variant-row').remove();
            });

        });
    </script>
@endpush
