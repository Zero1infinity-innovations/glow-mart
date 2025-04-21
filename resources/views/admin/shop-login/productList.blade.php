@extends('admin.layouts.master')
@push('title')
    Product List
@endpush
@section('content')
    <div class="row">
        <div class="col-6">
            <h6 class="mb-0 text-uppercase">Product</h6>
        </div>
    </div>
    <hr />
    @if (session('success'))
        <div class="alert alert-success mt-3 mb-2">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered no-footer" id="data-table">
                    <thead class="table-light">
                        <tr id="thead-html">
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Product Variance</th>
                            <th>Sale Price</th>
                            <th>MRP Price</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignedProducts as $productId => $productGroup)
                            @php
                                $product = $productGroup->first()->product;
                            @endphp
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <img src="{{ asset($product->product_image) }}" style="border-radius:50px;"
                                        width="50" height="50" alt="Product Image">
                                </td>
                                <td>{{ $product->product_name }}</td>

                                {{-- Show All Variants via SKU --}}
                                <td>
                                    @foreach ($productGroup as $item)
                                        <div>
                                            SKU: <strong>{{ $item->sku }}</strong><br>
                                            Variant Price: ₹{{ $item->variant->price ?? 'N/A' }}<br>
                                            Quantity: {{ $item->qty }}
                                            <hr class="my-1">
                                        </div>
                                    @endforeach
                                </td>

                                <td>{{ $product->sale_price }}/unit</td>
                                <td>{{ $product->mrp_price }}/unit</td>
                                <td>
                                    {{ $product->product_status == 1 ? 'Active' : 'Inactive' }}
                                </td>

                                <td>
                                    {{ $product->payment_method == 'cod_only' ? 'COD' : 'Prepaid' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>


                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".delete-product").forEach(button => {
                button.addEventListener("click", function() {
                    let productId = this.getAttribute("data-id");

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This record will be deleted permanently!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById("delete-form-" + productId).submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
