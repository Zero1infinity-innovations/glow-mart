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
            <h6 class="mb-0 text-uppercase">Add Stock</h6>
        </div>
        <div class="col-6 text-end px-0 px-lg-3">
            <a href="{{ route('admin.inventory.index') }}" class="btn btn-primary btn-sm px-3">
                <i class='bx bx-plus'></i> Back
            </a>
        </div>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.inventory.store') }}" method="post">
                @csrf
                <label> Product </label>
                <select name="product_id" class="form-control" id="product-select">
                    <option value="">Select Product</option>
                    @foreach ($products as $item)
                        <option value="{{ $item->id }}" data-qty="{{ $item->quantity ?? 0 }}">
                            {{ $item->product_name }}
                        </option>
                    @endforeach
                </select>

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
        document.getElementById('product-select').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const qty = selectedOption.getAttribute('data-qty') || 0;
            document.getElementById('qty-input').value = qty;

            // ✅ Shops fetch using AJAX
            const productId = this.value;

            if (productId) {
                // Clear previous shop options
                const shopSelect = document.getElementById('shop-select');
                shopSelect.innerHTML = '';

                $.ajax({
                    url: '{{ route('admin.inventory.getShop') }}',
                    type: 'GET',
                    data: {
                        product_id: productId
                    },
                    success: function(response) {
                        // Add new shops based on the selected product
                        response.forEach(shop => {
                            const option = document.createElement('option');
                            option.value = shop.id;
                            option.text = shop.shop_name;
                            shopSelect.appendChild(option);
                        });
                    },
                    error: function() {
                        alert('Shop list load karne me dikkat aayi.');
                    }
                });
            } else {
                // If no product is selected, reset shop select options
                document.getElementById('shop-select').innerHTML = '<option value="">Select Shop</option>';
            }
        });
    </script>
@endpush
