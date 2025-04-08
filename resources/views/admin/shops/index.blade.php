@extends('admin.layouts.master')
@push('title')
Product List
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Shops</h6>
    </div>
    <div class="col-6 text-end px-0 px-lg-3">
        <a href="{{route('admin.shops.create')}}" class="btn btn-primary btn-sm px-3"><i class='bx bx-plus'></i>Add</a>
    </div>
</div>
<hr />
@if(session('success'))
<div class="alert alert-success mt-3 mb-2">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered no-footer" id="categoryList">
                <thead class="table-light">
                    <tr id="thead-html">
                    <tr>
                        <th>ID</th>
                        <th>Shop Image</th>
                        <th>Shop Name</th>
                        <th>Owner Name</th>
                        <th>Owner Email</th>
                        <th>City</th>
                        <th>Pincode</th>
                        <th>Actions</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>

                    @php $i=1 @endphp
                    @forelse ($shops as $shop)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            <img src="{{ asset($shop->shop_image) }}" style="border-radius:50px;" width="50" height="50"
                                alt="Shop Image">
                        </td>
                        <td>{{ $shop->shop_name }}</td>
                        <td>{{ $shop->owner_name }}</td>
                        <td>{{ $shop->owner_email }}</td>
                        <td>{{ $shop->city }}</td>
                        <td>{{ $shop->pincode }}</td>
                        <td>
                            <a href="{{ route('admin.shops.edit', $shop->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.shops.destroy', $shop->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <button class="btn btn-primary btn-sm assign-product-btn" data-shop-id="{{ $shop->id }}"
                                data-bs-toggle="modal" data-bs-target="#assignProductModal">Assign Product</button>
                        </td>
                    </tr>
                    @php $i++ @endphp
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No Shop Record.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $shops->links() }}
        </div>
    </div>
</div>
<!-- Assign Product Module Start -->
<!-- Assign Product Modal -->
<div class="modal fade" id="assignProductModal" tabindex="-1" aria-labelledby="assignProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignProductModalLabel">Assign Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignProductForm">
                    @csrf
                    <input type="hidden" name="shop_id" id="modalShopId">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>
                                    <input type="checkbox" name="product_ids[]" value="{{ $product->id }}"
                                        class="product-checkbox">
                                </td>
                                <td>
                                    <img src="{{ asset($product->product_image) }}" style="border-radius:50px;"
                                        width="50" height="50" alt="Shop Image">
                                </td>
                                <td>{{ $product->product_name }}</td>
                                <td>
                                    <input type="number" name="quantities[{{ $product->id }}]"
                                        class="form-control quantity-input" min="1" disabled>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" id="assignShopButton" class="btn btn-success">Assign Shop</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Assign Product Module End -->
@endsection
@push('script')
<!-- Add this in your <head> section -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {

    $(".assign-product-btn").on("click", function() {
        var shopId = $(this).data("shop-id");
        $("#modalShopId").val(shopId);
    });

    $(document).on("change", ".product-checkbox", function() {
        var quantityInput = $(this).closest("tr").find(".quantity-input");
        quantityInput.prop("disabled", !this.checked);
    });

    $("#assignShopButton").on("click", function() {
        var shopId = $("#modalShopId").val();
        var selectedProducts = [];
        var quantities = {};

        // Gather the selected products and their quantities
        $(".product-checkbox:checked").each(function() {
            var productId = $(this).val();
            var quantity = $(this).closest("tr").find(".quantity-input").val();
            quantities[productId] = quantity;
            selectedProducts.push(productId);
        });

        if (selectedProducts.length === 0) {
            Swal.fire({
                title: 'Error!',
                text: 'Please select at least one product.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to assign these products to this shop.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, assign!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    shop_id: shopId,
                    product_ids: selectedProducts,
                    quantities: quantities,
                    _token: $("input[name='_token']").val()
                };

                // Send AJAX request to store the data
                $.ajax({
                    url: "{{ route('admin.shops.assign') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Success Alert
                            Swal.fire({
                                title: 'Success!',
                                text: 'Products have been successfully assigned to the shop.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location
                                .reload(); // Reload the page to show updated data
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to assign products.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
});
</script>
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